# CRUD PORTO and Angular Generator Container for [apiato 4.0.2](https://github.com/apiato/apiato)

This is a [PORTO](https://github.com/Porto-SAP/Documentation) Container for [apiato 4.0.2](https://github.com/apiato/apiato) to scaffold you applications, at the moment the package generates the API stuff only, and generates an Angular 2+ module that consumes the generated container API. There is a lot of work to do, pull requests are very welcome!! ^_^

If you don't know apiato already, go to the [apiato DOCS site](http://apiato.io/) and give it a try, it's an amazing project!!

## Install

>*NOTES:*
>This container doesn't need a external base layout anymore!!
>This container is tested on [Laravel Homestead](https://laravel.com/docs/5.4/homestead), so I sugest you to use Homestead as your development environment.

You must have [PHP_CodeSniffer](https://pear.php.net/package/PHP_CodeSniffer) installed:

```bash
sudo pear install PHP_CodeSniffer
```

You must have [Codeception](http://codeception.com/) installed:

```bash
composer global require "codeception/codeception=*"
composer global require "codeception/specify=*"
composer global require "codeception/verify=*"
```

If your development environment is Homestead, then these requirements are done. But if not, you should:

```bash
sudo ln -s ~/vagrant/.composer/vendor/bin/codecept /usr/local/bin/codecept
```

> Replace `~/vagrant/.composer/vendor/bin/codecept`with the global Composer path, to know where is that path execute`composer config --list --global | grep home`, you will see the home path for composer.

Now from the apiato root folder:

```bash
git clone https://github.com/llstarscreamll/Crud.git app/Containers/Crud
# this will add some Codeception helpers and TrashedCriteira on Ship folder
php artisan vendor:publish --provider="App\Containers\Crud\Providers\MainServiceProvider" --tag=classes
composer update
```

If you want to customize the code templates, run this command:

```bash
php artisan vendor:publish --provider="App\Containers\Crud\Providers\MainServiceProvider" --tag=templates
```

And go to `apiato/resources/vendor/crud` and make your convinience modifications.

Now go to `apiato.dev/crud` to start using the app.

## What is Generated?

Here are a quick overview of the generated folders/files to give you the big idea of what is generated from a package named _Library_ with an migration table called _books_, off course not a real life example, just have different kind of fields to prove some functionalities, this example is taking from the functional tests, so with the following setup:

![CRUD Setup GUI](https://cloud.githubusercontent.com/assets/2442445/25891986/93ccc538-3538-11e7-8c35-087736c8aa9f.png "CRUD Setup GUI")

The generated code will be:

### [apiato 4.0.2](https://github.com/apiato/apiato) Container

The generated container intends to follow the [PORTO](https://github.com/Mahmoudz/Porto) architectural pattern. A small difference with the **apiato** containers is that tests are generated with [Codeception](http://codeception.com/) unless **phpunit**, these tests are [namespaced](http://codeception.com/docs/08-Customization#Namespaces) with the container name. The generated API has some end points useful to work with the generated Angular module forms, e.g. serving a entity "Form Model/Select List" to build forms from server without update the Angular module, and have an entity list array to be used on select dropdowns (like some DB users list or something else). Obviosly the form builder on the Angular side is providen by the [Hello-Angular](https://github.com/llstarscreamll/Hello-Angular) project, the generated Angular module fits very well with *Hello-Angular*, but you can use it on your own main Angular project, just make sure to satisfy the dependencies from the generated module.

```bash
|─── Library
    ├── Actions
    │   └── Book
    │       ├── BookFormDataAction.php
    │       ├── CreateBookAction.php
    │       ├── DeleteBookAction.php
    │       ├── GetBookAction.php
    │       ├── ListAndSearchBooksAction.php
    │       ├── RestoreBookAction.php
    │       └── UpdateBookAction.php
    ├── codeception.yml
    ├── composer.json
    ├── Configs
    │   └── book-form-model.php
    ├── Data
    │   ├── Criterias
    │   │   └── Book
    │   │       └── AdvancedBookSearchCriteria.php
    │   ├── Factories
    │   │   └── BookFactory.php
    │   ├── Migrations
    │   ├── Repositories
    │   │   └── BookRepository.php
    │   └── Seeders
    ├── Exceptions
    │   ├── BookCreationFailedException.php
    │   └── BookNotFoundException.php
    ├── Models
    │   └── Book.php
    ├── Tasks
    │   └── Book
    │       ├── CreateBookTask.php
    │       ├── DeleteBookTask.php
    │       ├── GetBookTask.php
    │       ├── ListAndSearchBooksTask.php
    │       ├── RestoreBookTask.php
    │       └── UpdateBookTask.php
    ├── tests
    │   ├── acceptance
    │   │   └── _bootstrap.php
    │   ├── acceptance.suite.yml
    │   ├── api
    │   │   ├── Book
    │   │   │   ├── BookFormDataCest.php
    │   │   │   ├── BookFormModelCest.php
    │   │   │   ├── CreateBookCest.php
    │   │   │   ├── DeleteBookCest.php
    │   │   │   ├── GetBookCest.php
    │   │   │   ├── ListAndSearchBooksCest.php
    │   │   │   ├── RestoreBookCest.php
    │   │   │   └── UpdateBookCest.php
    │   │   └── _bootstrap.php
    │   ├── api.suite.yml
    │   ├── _bootstrap.php
    │   ├── _data
    │   │   └── dump.sql
    │   ├── _envs
    │   ├── functional
    │   │   └── _bootstrap.php
    │   ├── functional.suite.yml
    │   ├── _output
    │   ├── _support
    │   │   ├── AcceptanceTester.php
    │   │   ├── ApiTester.php
    │   │   ├── FunctionalTester.php
    │   │   ├── _generated
    │   │   │   ├── AcceptanceTesterActions.php
    │   │   │   ├── ApiTesterActions.php
    │   │   │   ├── FunctionalTesterActions.php
    │   │   │   └── UnitTesterActions.php
    │   │   ├── Helper
    │   │   │   ├── Acceptance.php
    │   │   │   ├── Api.php
    │   │   │   ├── Functional.php
    │   │   │   ├── Unit.php
    │   │   │   └── UserHelper.php
    │   │   └── UnitTester.php
    │   ├── unit
    │   │   └── _bootstrap.php
    │   └── unit.suite.yml
    └── UI
        ├── API
        │   ├── Controllers
        │   │   └── BookController.php
        │   ├── Requests
        │   │   └── Book
        │   │       ├── CreateBookRequest.php
        │   │       ├── DeleteBookRequest.php
        │   │       ├── GetBookRequest.php
        │   │       ├── ListAndSearchBooksRequest.php
        │   │       ├── RestoreBookRequest.php
        │   │       └── UpdateBookRequest.php
        │   ├── Routes
        │   │   ├── BookFormData.v1.private.php
        │   │   ├── BookFormModel.v1.private.php
        │   │   ├── CreateBook.v1.private.php
        │   │   ├── DeleteBook.v1.private.php
        │   │   ├── GetBook.v1.private.php
        │   │   ├── ListAndSearchBooks.v1.private.php
        │   │   ├── RestoreBook.v1.private.php
        │   │   └── UpdateBook.v1.private.php
        │   └── Transformers
        │       └── BookTransformer.php
        ├── CLI
        └── WEB
            ├── Controllers
            ├── Requests
            ├── Routes
            └── Views
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

If you have foreign keys and you will use the `{Entity}FormDataAction` class, add this method on `App\Ship\Parents\Repositories\Repository`:

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
            ->all(['id', 'name'])
            ->map(function ($item) use($key, $value) {
                return [
                    $key => $item->getHashedKey(),
                    $value => $item->name, // add more info for you convinience, if any
                ];
            })->all();
    }
```

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
    │   └── book.actions.ts
    ├── components
    │   ├── book
    │   │   ├── book-form-fields.component.css
    │   │   ├── book-form-fields.component.html
    │   │   ├── book-form-fields.component.spec.ts
    │   │   ├── book-form-fields.component.ts
    │   │   ├── book-search-advanced.component.css
    │   │   ├── book-search-advanced.component.html
    │   │   ├── book-search-advanced.component.spec.ts
    │   │   ├── book-search-advanced.component.ts
    │   │   ├── book-search-basic.component.css
    │   │   ├── book-search-basic.component.html
    │   │   ├── book-search-basic.component.spec.ts
    │   │   ├── book-search-basic.component.ts
    │   │   ├── books-table.component.css
    │   │   ├── books-table.component.html
    │   │   ├── books-table.component.spec.ts
    │   │   ├── books-table.component.ts
    │   │   └── index.ts
    │   └── index.ts
    ├── containers
    │   ├── book
    │   │   ├── book-abstract.page.ts
    │   │   ├── book-form.page.css
    │   │   ├── book-form.page.html
    │   │   ├── book-form.page.spec.ts
    │   │   ├── book-form.page.ts
    │   │   ├── index.ts
    │   │   ├── list-and-search-books.page.css
    │   │   ├── list-and-search-books.page.html
    │   │   ├── list-and-search-books.page.spec.ts
    │   │   └── list-and-search-books.page.ts
    │   └── index.ts
    ├── effects
    │   ├── book.effects.ts
    │   └── index.ts
    ├── library.module.ts
    ├── library-routing.module.ts
    ├── models
    │   ├── bookPagination.ts
    │   └── book.ts
    ├── reducers
    │   └── book.reducer.ts
    ├── routes
    │   ├── book.routes.ts
    │   └── index.ts
    ├── services
    │   ├── book.service.ts
    │   └── index.ts
    ├── translations
    │   └── es
    │       ├── book.ts
    │       └── index.ts
    └── utils
        ├── book-testing-util.ts
        └── book-testing.util.ts
```

## Tests

To execute this packages tests, go to the package `app/Containers/Crud` folder and execute:

```bash
codecept run functional
```
