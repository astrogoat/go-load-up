<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGoLoadUpSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('go-load-up.enabled', false);
         $this->migrator->add('go-load-up.white_glove_shopify_product_ID', '');
        // $this->migrator->add('go-load-up.url', '');
        // $this->migrator->addEncrypted('go-load-up.access_token', '');
    }

    public function down()
    {
        $this->migrator->delete('go-load-up.enabled');
         $this->migrator->delete('go-load-up.white_glove_shopify_product_ID');
        // $this->migrator->delete('go-load-up.url');
        // $this->migrator->delete('go-load-up.access_token');
    }
}
