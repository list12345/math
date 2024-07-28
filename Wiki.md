
## Create Migration

### Go to root folder and run command:
* php src/yii migrate/create {migration name}

- `Create new migration '{migration path}'? (yes|no) [no]:yes`

## Apply Migration
### Go to root folder and run command:

* php src/yii migrate/up --interactive=0

- `Apply the above migration? (yes|no) [no]:yes`

## Gii Generator

### Setup
Make sure that the console module is enabled in app/ng/config/console.php.
```
if (true) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}
```

### Generate Model
* php src/yii gii/model --tableName={table name} --modelClass={model class name}

- `Ready to generate the selected files? (yes|no) [yes]:yes`

### Generate CRUD
* php src/yii gii/crud --modelClass=app\\\models\\\CatalogItem --controllerClass=app\\\modules\\\backend\\\controllers\\\CatalogItemController --viewPath=@app/modules/backend/views/catalog-item --searchModelClass=app\\\models\\\CatalogItemSearch

OR

* php src/yii gii/crud --modelClass={class namespace, e.g.: app\\\models\\\CatalogItem} --controllerClass=app\\\\{partial path to future controller, e.g.:  app\\\modules\\\backend\\\controllers\\\CatalogItemController} --viewPath=@app/{partial path to views, e.g.: @app/modules/backend/views/catalog-item} --enablePjax=1 --searchModelClass=app\\\\{partial path to future search model, e.g.: app\\\models\\\CatalogItemSearch}

- `Ready to generate the selected files? (yes|no) [yes]:yes`

  Please move files and modify their namespaces if it's necessary. 