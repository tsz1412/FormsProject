<?php
namespace Tsz\Novado\Plugins\ACF;
class SyncFields
{
    public function __construct()
    {
        add_filter('acf/settings/save_json', [$this, 'save']);
        add_filter('acf/settings/load_json', [$this, 'load']);

    }


    public function save(): string
    {
        return $this->get_path();
    }

    public function load($paths) : array{
        // remove original path (optional)
        unset($paths[0]);
        // append path
        $paths[] = $this->get_path();
        // return
        return $paths;

    }

    private function get_path(): string
    {
        return get_stylesheet_directory() . '/inc/plugins/acf/field-groups';
    }
}