# CRUD Container for [apiato 4.0.2](https://github.com/apiato/apiato)

This is a [PORTO](https://github.com/Porto-SAP/Documentation) Container for [apiato 4.0.2](https://github.com/apiato/apiato) to scaffold you applications, at the moment the package generates the API stuff only, and generates an Angular 2+ module that consumes the generated API. There is a lot of work to do, pull requests are very welcome!! ^_^

If you don't know apiato already, go to the [apiato DOCS site](http://apiato.io/) and give it a try, it's an amazing project!!

## Install

This container needs a base layout, at the moment the package works with this [Theme Container](https://github.com/llstarscreamll/Theme), go there and check the install process, it's very quick!!.

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

If your development environment is Homestead, then these requirements are done. But if not you should:

```bash
sudo ln -s ~/vagrant/.composer/vendor/bin/codecept /usr/local/bin/codecept
```

> Replace `~/vagrant/.composer/vendor/bin/codecept`with the global Composer path, to know where is that path execute`composer config --list --global | grep home`, you will see the home path for composer.

Now from the apiato root folder:

```bash
git clone https://github.com/llstarscreamll/Crud.git app/Containers/Crud
# this will add a Codeception Helper and Trashed criteira on Ship folder
php artisan vendor:publish --provider="App\Containers\Crud\Providers\MainServiceProvider"
composer update
```

Now go to `apiato.dev/crud` to start using the app.

## Generated files

Here are a quick overview of the generated folders/files to give you the big idea of what is generated from a package named Library with an table called books, off course not a real life example, just have different kind of fields to prove some functionalities, this example is taking from the package functional tests, so with the following setup:

![CRUD Setup GUI](https://cloud.githubusercontent.com/assets/2442445/24436152/7fb42e92-13ff-11e7-95e7-89eefd7892db.png "CRUD Setup GUI")

The generated code will be:

### [apiato 4.0.2](https://github.com/apiato/apiato) Container

The generated container intends to follow the [PORTO](https://github.com/Porto-SAP/Documentation) architectural pattern. A small difference with the **apiato** containers is that tests are generated with [Codeception](http://codeception.com/) unless **phpunit**, these tests are name spaced with the container name. The generated API has some end points useful to work with the generated Angular 2+ module, e.g. serving a entity "Form Model" to build forms from server without update the Angular module, and serve the form data dependencies like some DB users list options or something else. Obviosly the from builder on the Angular side is providen by the [Hello-Angular](https://github.com/llstarscreamll/Hello-Angular) project, the generated Angular module fits very well with this project.

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

### Angular 2+ Module

> **NOTE:**
> To generate your Angular 2+ module you must have the generated apiato Container placed on the `app/Containers` folder. Why? Because the generator create fake data with the generated container factories on the Angular module tests.

This module is intended to work with this [Hello-Angular](https://github.com/llstarscreamll/Hello-Angular) application, the generated module should be copied on the `src/app/modules` folder, then you should declare the module on the main modules array `src/app/modules.ts` file and reducers on the `src/app/reducers.ts` file. The generated module intends to follow all the best practices on the Angular 2+ world based on the [ngrx example app](https://github.com/ngrx/example-app), [Yatrum](https://github.com/aviabird/yatrum) and many other resources. Some libraries used on the generated code are:

- @ngrx/store
- @ngrx/effects
- @ngrx/router-store
- ReactiveForms
- @ngx-translate/core
- ngx-bootstrap
- etc...

The generated Angular module has many tests, you should execute these tests to ensure that everything it's working as intendet.

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

To execute the packages tests, go to the package `app/Containers/Crud` folder and execute:

```bash
codecept run functional
```
