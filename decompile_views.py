import re
import os
import glob

views_dir = 'storage/framework/views'
target_base = 'resources/views'

# Map compiled views to source files
mapping = {}
for filepath in glob.glob(os.path.join(views_dir, '*.php')):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    m = re.search(r'/\*\*PATH (.+?) ENDPATH\*\*/', content)
    if m:
        source_path = m.group(1).replace('\\', '/')
        if 'resources/views/' in source_path:
            relative_path = re.sub(r'^.*/resources/views/', '', source_path)
            mapping[relative_path] = filepath

print(f"Found {len(mapping)} compiled views to decompile:")
for rel in sorted(mapping.keys()):
    print(f"  - {rel}")
print()

PHP_OPEN = '<?php'
PHP_CLOSE = '?>'

for relative_path, compiled_file in sorted(mapping.items()):
    with open(compiled_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    original_content = content  # Keep for layout detection
    
    # Remove PATH comment at the end
    content = re.sub(r'<\?php\s*/\*\*PATH.*?ENDPATH\*\*/\s*\?>', '', content, flags=re.DOTALL)
    
    # Detect layout wrapper
    layout_wrapper = None
    if 'AppLayout::resolve' in original_content:
        layout_wrapper = 'app-layout'
    elif 'GuestLayout::resolve' in original_content:
        layout_wrapper = 'guest-layout'
    
    # Remove component wrapper (opening)
    # Pattern: <?php if (isset($component)) { $__componentOriginal... 
    # through: <?php $component->withAttributes([]); ?>
    content = re.sub(
        r'<\?php if \(isset\(\$component\)\) \{ \$__componentOriginal.*?withAttributes\(\[\]\);\s*\?>\s*',
        '', content, count=1, flags=re.DOTALL
    )
    
    # Remove component wrapper (closing)
    # Pattern: <?php echo $__env->renderComponent(); ?> ... to end
    content = re.sub(
        r'\s*<\?php echo \$__env->renderComponent\(\);\s*\?>\s*<\?php endif;\s*\?>\s*<\?php if \(isset\(\$__attributesOriginal[a-f0-9]+\)\).*$',
        '', content, flags=re.DOTALL
    )
    
    # === SLOTS ===
    content = re.sub(
        r"<\?php\s*\\\$__env->slot\('(\w+)',\s*null,\s*\[\]\);\s*\?>",
        r'<x-slot name="\1">',
        content
    )
    content = re.sub(
        r"<\?php\s*\\\$__env->endSlot\(\);\s*\?>",
        '</x-slot>',
        content
    )
    # Simpler slot patterns
    content = re.sub(
        r"<\?php \$__env->slot\('(\w+)', null, \[\]\); \?>",
        r'<x-slot name="\1">',
        content
    )
    content = re.sub(
        r"<\?php \$__env->endSlot\(\); \?>",
        '</x-slot>',
        content
    )
    
    # === ANONYMOUS COMPONENT BLOCKS ===
    def replace_component(m):
        full = m.group(0)
        # Extract component view name
        view_match = re.search(r"'view'\s*=>\s*'([^']+)'", full)
        if not view_match:
            return full
        view_name = view_match.group(1)
        tag = view_name.replace('components.', '').replace('.', '-')
        
        # Extract attributes from withAttributes
        attrs_match = re.search(r"withAttributes\((\[.*?\])\)", full, re.DOTALL)
        attr_str = ''
        if attrs_match:
            attrs_raw = attrs_match.group(1)
            # Simple string attrs
            for am in re.finditer(r"'(\w+)'\s*=>\s*'([^']*)'", attrs_raw):
                name, val = am.group(1), am.group(2)
                attr_str += f' {name}="{val}"'
            # Bound attrs with sanitizeComponentAttribute
            for bm in re.finditer(r"'(\w+)'\s*=>\s*\\Illuminate\\View\\Compilers\\BladeCompiler::sanitizeComponentAttribute\((.+?)\)", attrs_raw):
                name, val = bm.group(1), bm.group(2)
                attr_str += f' :{name}="{val}"'
        
        return f'<x-{tag}{attr_str} />'
    
    # Match full anonymous component blocks
    content = re.sub(
        r'<\?php if \(isset\(\$component\)\) \{ \$__componentOriginal[a-f0-9]+.*?AnonymousComponent::resolve.*?withAttributes\(.*?\);\s*\?>',
        replace_component,
        content,
        flags=re.DOTALL
    )
    
    # Clean up renderComponent + cleanup blocks from anonymous components
    content = re.sub(
        r'<\?php echo \$__env->renderComponent\(\);\s*\?>\s*<\?php endif;\s*\?>\s*<\?php if \(isset\(\$__attributesOriginal[a-f0-9]+\)\):\s*\?>\s*<\?php \$attributes = \$__attributesOriginal[a-f0-9]+;\s*\?>\s*<\?php unset\(\$__attributesOriginal[a-f0-9]+\);\s*\?>\s*<\?php endif;\s*\?>\s*<\?php if \(isset\(\$__componentOriginal[a-f0-9]+\)\):\s*\?>\s*<\?php \$component = \$__componentOriginal[a-f0-9]+;\s*\?>\s*<\?php unset\(\$__componentOriginal[a-f0-9]+\);\s*\?>\s*<\?php endif;\s*\?>',
        '',
        content,
        flags=re.DOTALL
    )
    
    # === BASIC BLADE DIRECTIVES ===
    
    # @csrf
    content = content.replace('<?php echo csrf_field(); ?>', '@csrf')
    
    # @method
    content = re.sub(r"<\?php echo method_field\('(\w+)'\);\s*\?>", r"@method('\1')", content)
    
    # {{ expr }} - escaped output
    content = re.sub(r'<\?php echo e\((.+?)\);\s*\?>', r'{{ \1 }}', content)
    
    # @vite
    content = re.sub(
        r"<\?php echo app\('Illuminate\\\\Foundation\\\\Vite'\)\((\[.+?\])\);\s*\?>",
        r'@vite(\1)',
        content
    )
    
    # @include
    content = re.sub(
        r"<\?php echo \$__env->make\('([^']+)',\s*array_diff_key\(get_defined_vars\(\),\s*\['__data'\s*=>\s*1,\s*'__path'\s*=>\s*1\]\)\)->render\(\);\s*\?>",
        r"@include('\1')",
        content
    )
    content = re.sub(
        r"<\?php echo \$__env->make\('([^']+)',\s*(\[.+?\]),\s*array_diff_key.*?\)->render\(\);\s*\?>",
        r"@include('\1', \2)",
        content,
        flags=re.DOTALL
    )
    
    # {!! expr !!} - unescaped output (after {{ }} to avoid double matching)
    content = re.sub(r'<\?php echo (.+?);\s*\?>', r'{!! \1 !!}', content)
    
    # @foreach
    content = re.sub(
        r"<\?php \$__currentLoopData = (.+?);\s*\$__env->addLoop\(\$__currentLoopData\);\s*foreach\(\$__currentLoopData as (.+?)\):\s*\$__env->incrementLoopIndices\(\);\s*\$loop = \$__env->getLastLoop\(\);\s*\?>",
        r'@foreach(\1 as \2)',
        content,
        flags=re.DOTALL
    )
    content = re.sub(
        r"<\?php endforeach;\s*\$__env->popLoop\(\);\s*\$loop = \$__env->getLastLoop\(\);\s*\?>",
        '@endforeach',
        content
    )
    
    # @forelse / @empty
    content = re.sub(
        r"<\?php \$__empty_\d+ = true;\s*\$__currentLoopData = (.+?);\s*\$__env->addLoop\(\$__currentLoopData\);\s*foreach\(\$__currentLoopData as (.+?)\):\s*\$__env->incrementLoopIndices\(\);\s*\$loop = \$__env->getLastLoop\(\);\s*\$__empty_\d+ = false;\s*\?>",
        r'@forelse(\1 as \2)',
        content,
        flags=re.DOTALL
    )
    content = re.sub(
        r"<\?php endforeach;\s*\$__env->popLoop\(\);\s*\$loop = \$__env->getLastLoop\(\);\s*if\s*\(\$__empty_\d+\):\s*\?>",
        '@empty',
        content,
        flags=re.DOTALL
    )
    
    # @if / @elseif / @else / @endif
    content = re.sub(r'<\?php if\((.+?)\):\s*\?>', r'@if(\1)', content)
    content = re.sub(r'<\?php elseif\((.+?)\):\s*\?>', r'@elseif(\1)', content)
    content = content.replace('<?php else: ?>', '@else')
    content = content.replace('<?php endif; ?>', '@endif')
    
    # Simple PHP expression blocks
    content = re.sub(r'<\?php\s+(\$\w+\s*=\s*.+?;)\s*\?>', r'@php \1 @endphp', content)
    
    # Any remaining <?php ... ?> blocks
    content = re.sub(r'<\?php\s+(.+?)\s*\?>', r'@php \1 @endphp', content)
    
    # Clean up excessive blank lines
    content = re.sub(r'\n{3,}', '\n\n', content)
    
    # Trim
    content = content.strip()
    
    # Add layout wrapper if needed
    if layout_wrapper:
        content = f'<x-{layout_wrapper}>\n{content}\n</x-{layout_wrapper}>'
    
    # Write to target
    target_path = os.path.join(target_base, relative_path)
    os.makedirs(os.path.dirname(target_path), exist_ok=True)
    with open(target_path, 'w', encoding='utf-8') as f:
        f.write(content + '\n')
    print(f'Restored: {relative_path}')

print(f"\nDone! Restored {len(mapping)} files.")
