# Customizing the database
```bash
php artisan vendor:publish --provider="Yormy\ChaskiLaravel\ChaskiServiceProvider" --tag="migrations"
```

    ->databaseTables(
        'chaski_logs',
        'chaski_blocks'
    )
