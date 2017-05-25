# CRUD PORTO and Angular Generator Container for [apiato 4.0.2](https://github.com/apiato/apiato)

This is a [PORTO](https://github.com/Porto-SAP/Documentation) Container for [apiato 4.0.2](https://github.com/apiato/apiato) to scaffold you applications, at the moment the package generates the API stuff only, and generates an Angular 2+ module that consumes the generated container API. There is a lot of work to do, pull requests are very welcome!! ^_^

If you don't know apiato already, go to the [apiato DOCS site](http://apiato.io/) and give it a try, it's an amazing project!!

>**NOTE:**
>This container is tested on [Laravel Homestead](https://laravel.com/docs/5.4/homestead), so I sugest you to use Homestead as your development environment.

## Install

From the apiato root folder:

```bash
git clone https://github.com/llstarscreamll/Crud.git app/Containers/Crud
# this will add some Codeception helpers and criterias on Ship folder
php artisan vendor:publish --provider="App\Containers\Crud\Providers\MainServiceProvider" --tag=classes
composer update
```

If you have foreign keys on your table, the generated transformer will try to hash that foreign keys with this method that you must put in `App\Ship\Parents\Transformers\Transformer` abstract class:

```php
    public function hashKey($id)
    {
        if (config('apiato.hash-id')) {
            return Hashids::encode($id);
        }

        return $id;
    }
```

If you will use the `SelectListFrom{Entity}` endpoint, add this method on `App\Ship\Parents\Repositories\Repository`:

```php
    /**
     * Return model list to be used on selects. The $key and $value parameters
     * says what the array item keys names should be. Example with $key = 'id'
     * and $value = 'label':
     * [
     *     [ 'id' => 1, 'label' => 'Foo' ],
     *     [ 'id' => 2, 'label' => 'Bar' ],
     * ]
     *
     * @param  string $key
     * @param  string $value
     * @return array
     */
    public function selectList(string $key = 'id', string $value = 'text')
    {
        return $this->model
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(function ($item) use($key, $value) {
                return [
                    $key => $item->getHashedKey(),
                    $value => $item->name, // add more info for you convinience, if any
                ];
            })->all();
    }
```

## Usage

Let's suppose that we want to create a container called **Library** that will manage **books** data, so let's create that container folder and the migration file:

```bash
# from the apiato root folder
mkdir -p app/Containers/Library/Data/Migrations
php artisan make:migration create_books_table --create=books --path=app/Containers/Library/Data/Migrations
```

Next we add some columns to that migration table and run the migration:

```bash
php artisan migrate
```

Since this package use **Codeception** to generate the CRUD app test suit, you **MUST** bootstrap and generate the api suit for your container:

```bash
# from the apiato root folder
codecept bootstrap --namespace=Library app/Containers/Library/
codecept g:suit api -c app/Containers/Library/
```

Now you can go to [apiato.dev/crud](apiato.dev/crud) to start configuring your CRUD container/module.

>NOTE: the codeception stuff is required to run once per container, from here you can add more migration tables without setup codecept again.

After you have generated your container/module, you should run the generated tests to make shure that the generated code it's ok:

```bash
# from the apiato root folder
codecept build -c app/Containers/Library/ # required each time you generate CRUD for newly created table 
codecept run -c app/Containers/Library/
phpcbf app/Containers/Library/ --standard=PEAR,PSR1,PSR2 # optional, run any Code Beautifier you preffer
# from the Hello-Angular root folder
ng tests
```

## What is Generated?

Here are a quick overview of the generated folders/files to give you the big idea of what is generated from a package named _Library_ with an migration table called _books_, off course not a real life example, just have different kind of fields to prove some functionalities, this example is taking from the functional tests, **check the up to date final generated code for this example** in the [CrudExample](https://github.com/llstarscreamll/Crud/tree/3.0/CrudExample) folder. So with the following setup:

![CRUD Setup GUI](https://cloud.githubusercontent.com/assets/2442445/26444536/76dfb20c-4102-11e7-957e-453026ff6ea4.png "CRUD Setup GUI")

The generated code will be:

### [apiato 4.0.2](https://github.com/apiato/apiato) Container

The generated container intends to follow the [PORTO](https://github.com/Mahmoudz/Porto) architectural pattern. A small difference with the **apiato** containers is that tests are generated with [Codeception](http://codeception.com/) unless **phpunit**, these tests are [namespaced](http://codeception.com/docs/08-Customization#Namespaces) with the container name. The generated API has some end points useful to work with the generated Angular module forms, e.g. serving a entity "Form Model/Select List" to build forms from server without update the Angular module, and have an entity list array to be used on select dropdowns (like some DB users list or something else). Obviosly the form builder on the Angular side is providen by the [Hello-Angular](https://github.com/llstarscreamll/Hello-Angular) project, the generated Angular module fits very well with *Hello-Angular*, but you can use it on your own main Angular project, just make sure to satisfy the dependencies from the generated module.

```bash
|─── Library
    ├── Actions
    │   └── Book
    │       ├── CreateBookAction.php
    │       ├── DeleteBookAction.php
    │       ├── GetBookAction.php
    │       ├── ListAndSearchBooksAction.php
    │       ├── RestoreBookAction.php
    │       ├── SelectListFromBookAction.php
    │       └── UpdateBookAction.php
    ├── composer.json
    ├── Configs
    │   └── book-form-model.php
    ├── Data
    │   ├── Criterias
    │   │   └── AdvancedBookSearchCriteria.php
    │   ├── Factories
    │   │   └── BookFactory.php
    │   ├── Migrations
    │   ├── Repositories
    │   │   └── BookRepository.php
    │   └── Seeders
    │       └── BookPermissionsSeeder.php
    ├── Exceptions
    │   ├── BookCreationFailedException.php
    │   └── BookNotFoundException.php
    ├── Models
    │   └── Book.php
    ├── Tasks
    │   └── Book
    │       ├── CreateBookTask.php
    │       ├── DeleteBookTask.php
    │       ├── GetBookTask.php
    │       ├── ListAndSearchBooksTask.php
    │       ├── RestoreBookTask.php
    │       └── UpdateBookTask.php
    ├── tests
    │   ├── acceptance
    │   │   └── _bootstrap.php
    │   ├── acceptance.suite.yml
    │   ├── api
    │   │   ├── Book
    │   │   │   ├── BookFormModelCest.php
    │   │   │   ├── CreateBookCest.php
    │   │   │   ├── DeleteBookCest.php
    │   │   │   ├── GetBookCest.php
    │   │   │   ├── ListAndSearchBooksCest.php
    │   │   │   ├── RestoreBookCest.php
    │   │   │   ├── SelectListFromBookCest.php
    │   │   │   └── UpdateBookCest.php
    │   │   └── _bootstrap.php
    │   ├── api.suite.yml
    │   ├── _bootstrap.php
    │   ├── _data
    │   │   └── dump.sql
    │   ├── _envs
    │   ├── functional
    │   │   └── _bootstrap.php
    │   ├── functional.suite.yml
    │   ├── _output
    │   ├── _support
    │   │   ├── AcceptanceTester.php
    │   │   ├── ApiTester.php
    │   │   ├── FunctionalTester.php
    │   │   ├── _generated
    │   │   │   ├── AcceptanceTesterActions.php
    │   │   │   ├── FunctionalTesterActions.php
    │   │   │   └── UnitTesterActions.php
    │   │   ├── Helper
    │   │   │   ├── Acceptance.php
    │   │   │   ├── Api.php
    │   │   │   ├── Functional.php
    │   │   │   ├── LibraryHelper.php
    │   │   │   └── Unit.php
    │   │   └── UnitTester.php
    │   ├── unit
    │   │   └── _bootstrap.php
    │   └── unit.suite.yml
    └── UI
        └── API
            ├── Controllers
            │   └── BookController.php
            ├── Requests
            │   └── Book
            │       ├── CreateBookRequest.php
            │       ├── DeleteBookRequest.php
            │       ├── FormModelFromBookRequest.php
            │       ├── GetBookRequest.php
            │       ├── ListAndSearchBooksRequest.php
            │       ├── RestoreBookRequest.php
            │       ├── SelectListFromBookRequest.php
            │       └── UpdateBookRequest.php
            ├── Routes
            │   ├── CreateBook.v1.private.php
            │   ├── DeleteBook.v1.private.php
            │   ├── FormModelFromBook.v1.private.php
            │   ├── GetBook.v1.private.php
            │   ├── ListAndSearchBooks.v1.private.php
            │   ├── RestoreBook.v1.private.php
            │   ├── SelectListFromBook.v1.private.php
            │   └── UpdateBook.v1.private.php
            └── Transformers
                └── BookTransformer.php
```

If you don't want the main classes to be grouped on entity folders (e.g. Actions\Book\CreateBookAction), just leave unchecked the *Group main apiato classes?* on the GUI.

You should run the generated tests executing this command inside of the container to make sure that all is ok:

```bash
codecept run api
```

### Angular Module

> **NOTE:**
> To generate your Angular module you must have the respective generated apiato Container first. Why? Because the generator create fake data with the generated container factories on the Angular module tests.

This module is intended to work with this [Hello-Angular](https://github.com/llstarscreamll/Hello-Angular) application, when the generated module is placed in the *Hello-Angular* app (or your Angular app), then you must declare the module on the main modules array `src/app/modules.ts` file and reducers on the `src/app/reducers.ts` file, the reducers to be copied are commented on the generated `entity.reducers.ts` file to make things easy, following the _Library/books_ exampĺe, said reducers should look something like this:

```javascript
/* -----------------------------------------------------------------------------
Don't forget to import these reducer on the main app reducer!!

import * as fromBook from './library/reducers/book.reducer';

export interface State {
  book: fromBook.State;
}

const reducers = {
  book: fromBook.reducer,
};

// Book selectors
export const getBookState = (state: State) => state.book;
export const getBookSearchQuery = createSelector(getBookState, fromBook.getSearchQuery);
export const getBookFormModel = createSelector(getBookState, fromBook.getFormModel);
export const getBookFormData = createSelector(
  getReasonList,
  getUserList,
  (
    Reasons,
    Users,
  ) => ({
    Reasons,
    Users,
  })
);
export const getBookList = createSelector(getBookState, fromBook.getItemsList);
export const getBooksPagination = createSelector(getBookState, fromBook.getItemsPagination);
export const getSelectedBook = createSelector(getBookState, fromBook.getSelectedItem);
export const getBookLoading = createSelector(getBookState, fromBook.getLoading);
export const getBookMessages = createSelector(getBookState, fromBook.getMessages);

----------------------------------------------------------------------------- */
```

The generated module intends to follow all the best practices on the Angular world based on the [ngrx example app](https://github.com/ngrx/example-app), [Yatrum](https://github.com/aviabird/yatrum) and many other resources. Some libraries used on the generated code are:

- @ngrx/store
- @ngrx/effects
- @ngrx/router-store
- ReactiveForms
- @ngx-translate/core
- ngx-bootstrap
- etc...

The generated Angular module has many tests, you should execute these tests to ensure that everything is working as intendet by running `ng test`.

```bash
├── library
    ├── actions
    │   └── book.actions.ts
    ├── components
    │   ├── book
    │   │   ├── book-abstract.component.ts
    │   │   ├── book-form.component.html
    │   │   ├── book-form.component.spec.ts
    │   │   ├── book-form.component.ts
    │   │   ├── book-search-advanced.component.html
    │   │   ├── book-search-advanced.component.spec.ts
    │   │   ├── book-search-advanced.component.ts
    │   │   ├── book-search-basic.component.html
    │   │   ├── book-search-basic.component.spec.ts
    │   │   ├── book-search-basic.component.ts
    │   │   ├── books-table.component.html
    │   │   ├── books-table.component.spec.ts
    │   │   ├── books-table.component.ts
    │   │   └── index.ts
    │   └── index.ts
    ├── effects
    │   ├── book.effects.ts
    │   └── index.ts
    ├── library.module.ts
    ├── library-routing.module.ts
    ├── models
    │   ├── bookPagination.ts
    │   └── book.ts
    ├── pages
    │   ├── book
    │   │   ├── book-abstract.page.ts
    │   │   ├── book-form.page.html
    │   │   ├── book-form.page.spec.ts
    │   │   ├── book-form.page.ts
    │   │   ├── index.ts
    │   │   ├── list-and-search-books.page.html
    │   │   ├── list-and-search-books.page.spec.ts
    │   │   └── list-and-search-books.page.ts
    │   └── index.ts
    ├── reducers
    │   └── book.reducer.ts
    ├── routes
    │   ├── book.routes.ts
    │   └── index.ts
    ├── services
    │   ├── book.service.ts
    │   └── index.ts
    ├── translations
    │   └── es
    │       ├── book.ts
    │       └── index.ts
    └── utils
        └── book-testing.util.ts
```

## Tests

To execute this packages tests, you will need a file named `.env.mysql.testing` on your root folder like this:

```bash
APP_ENV=testing
APP_DEBUG=true
APP_NAME="apiato"
APP_URL=http://apiato.dev
API_URL=http://apiato.dev
APP_KEY=generatedKey
USER_NAMESPACE=App\Containers\User\Models\

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=test
DB_USERNAME=homestead
DB_PASSWORD=secret
```

Now go to the package `app/Containers/Crud` folder and execute:

```bash
codecept run functional
```
