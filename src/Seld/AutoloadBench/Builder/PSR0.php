<?php

namespace Seld\AutoloadBench\Builder;

use Seld\AutoloadBench\Builder;

class PSR0 extends Builder
{
    protected function build($classes, $path, $prefixMapLevel = 1)
    {
        $code = <<<'EOF'
<?php

$loader = new \Seld\AutoloadBench\Loader\PSR0();
$map = %s;

foreach ($map as $prefix => $path) {
    $loader->add($prefix, $path);
}

return $loader;
EOF
;

        $prefixes = array();
        foreach ($classes as $class) {
            $prefix = implode('\\', array_slice(explode('\\', $class), 0, $prefixMapLevel));
            $prefixes[$prefix] = $path;
        }

        file_put_contents($this->path.'/loader.php', sprintf($code, var_export($prefixes, true)));
    }
}
