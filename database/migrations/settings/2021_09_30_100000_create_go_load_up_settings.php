<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGoLoadUpSettings extends SettingsMigration
{
    public function up(): void
    {
        if($this->migrator->has('go-load-up.enabled')) {
            $this->migrator->add('go-load-up.enabled', false);
            $this->migrator->add('go-load-up.white_glove_shopify_product_id', '');
            $this->migrator->add('go-load-up.california_removal_only_mattress_shopify_id', '');
            $this->migrator->add('go-load-up.removal_only_mattress_shopify_id', '');
        }
    }

    public function down()
    {
        $this->migrator->delete('go-load-up.enabled');
        $this->migrator->delete('go-load-up.white_glove_shopify_product_id');
        $this->migrator->delete('go-load-up.california_removal_only_mattress_shopify_id');
        $this->migrator->delete('go-load-up.removal_only_mattress_shopify_id');
    }
}
