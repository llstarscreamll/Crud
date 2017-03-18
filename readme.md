# CRUD Container for Hello-API

This is a [PORTO](https://github.com/Porto-SAP/Documentation) Container for [Hello-API](https://github.com/Porto-SAP/Hello-API) to scaffold you applications, at the moment the package generates the API routes only, and generates an Angular 2 module that consumes the generated API. There is a lot of work to do, pull requests are very welcome!! ^_^

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

Now from the Hello-API root folder:

```bash
git clone https://github.com/llstarscreamll/Crud.git app/Containers/Crud
composer update
```

Now go to `hello.dev/crud` to start using the app.

## Generated files

Here are a quick overview of the generated folders/files to give you the big idea of what is generated from a package named Library with an table called books, off course not a real life example, just have different kind of fields to prove some functionalities, this example is taking from the package functional tests:

### Hello-API Container

The generated container intends to follow the [PORTO](https://github.com/Porto-SAP/Documentation) architectural pattern. A small difference with the Hello-API containers is that tests are generated with [Codeception](http://codeception.com/) unless **phpunit**, these tests are name spaced with the container name. The generated API has some end points useful to work with the generated Angular 2 module, e.g. serving a entity "Form Model" to build forms from server without update the Angular module, and serve the form data dependencies like some DB users list options or something else.

```bash
Library/
├── Actions
│   └── Book
│       ├── BookFormDataAction.php
│       ├── CreateBookAction.php
│       ├── DeleteBookAction.php
│       ├── GetBookAction.php
│       ├── ListAndSearchBooksAction.php
│       ├── RestoreBookAction.php
│       └── UpdateBookAction.php
├── codeception.yml
├── composer.json
├── Configs
│   └── book-form-model.php
├── Data
│   ├── Criterias
│   ├── Factories
│   │   └── BookFactory.php
│   ├── Migrations
│   ├── Repositories
│   │   └── BookRepository.php
│   └── Seeders
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
│   │   │   ├── BookFormDataCest.php
│   │   │   ├── BookFormModelCest.php
│   │   │   ├── CreateBookCest.php
│   │   │   ├── DeleteBookCest.php
│   │   │   ├── GetBookCest.php
│   │   │   ├── ListAndSearchBooksCest.php
│   │   │   ├── RestoreBookCest.php
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
│   │   │   ├── ApiTesterActions.php
│   │   │   ├── FunctionalTesterActions.php
│   │   │   └── UnitTesterActions.php
│   │   ├── Helper
│   │   │   ├── Acceptance.php
│   │   │   ├── Api.php
│   │   │   ├── Functional.php
│   │   │   ├── Unit.php
│   │   │   └── UserHelper.php
│   │   └── UnitTester.php
│   ├── unit
│   │   └── _bootstrap.php
│   └── unit.suite.yml
└── UI
    ├── API
    │   ├── Controllers
    │   │   └── BookController.php
    │   ├── Requests
    │   │   └── Book
    │   │       ├── CreateBookRequest.php
    │   │       ├── DeleteBookRequest.php
    │   │       ├── GetBookRequest.php
    │   │       ├── ListAndSearchBooksRequest.php
    │   │       ├── RestoreBookRequest.php
    │   │       └── UpdateBookRequest.php
    │   ├── Routes
    │   │   ├── BookFormData.v1.private.php
    │   │   ├── BookFormModel.v1.private.php
    │   │   ├── CreateBook.v1.private.php
    │   │   ├── DeleteBook.v1.private.php
    │   │   ├── GetBook.v1.private.php
    │   │   ├── ListAndSearchBooks.v1.private.php
    │   │   ├── RestoreBook.v1.private.php
    │   │   └── UpdateBook.v1.private.php
    │   └── Transformers
    │       └── BookTransformer.php
    ├── CLI
    └── WEB
        ├── Controllers
        ├── Requests
        ├── Routes
        └── Views
```

### Angular 2 Module

This module is intended to work with this [Hello-Angular](https://github.com/llstarscreamll/Hello-Angular) application, the generated module should be copied on the `src/app/modules` folder, then you should declare the component on the main module and reducers on the `Core/reducers/index.ts` module folder. The generated module intends to follow all the best practices on the Angular 2 world based on the [ngrx example app](https://github.com/ngrx/example-app), [Yatrum](https://github.com/aviabird/yatrum) and many other resources. Some libraries used on the generated code are:

- @ngrx/store
- @ngrx/effects
- @ngrx/router-store
- ReactiveForms
- ng2-translate
- ng2-bootstrap
- etc...

```bash
library
├── actions
│   └── book.actions.ts
├── components
│   ├── book
│   │   ├── book-form.component.css
│   │   ├── book-form.component.html
│   │   ├── book-form.component.ts
│   │   ├── books-table.component.css
│   │   ├── books-table.component.html
│   │   ├── books-table.component.ts
│   │   └── index.ts
│   └── index.ts
├── containers
│   ├── book
│   │   ├── book-details.page.css
│   │   ├── book-details.page.html
│   │   ├── book-details.page.ts
│   │   ├── create-book.page.css
│   │   ├── create-book.page.html
│   │   ├── create-book.page.ts
│   │   ├── edit-book.page.css
│   │   ├── edit-book.page.html
│   │   ├── edit-book.page.ts
│   │   ├── index.ts
│   │   ├── list-and-search-books.page.css
│   │   ├── list-and-search-books.page.html
│   │   └── list-and-search-books.page.ts
│   └── index.ts
├── effects
│   ├── book.effects.ts
│   └── index.ts
├── library.module.ts
├── library-routing.module.ts
├── models
│   ├── bookPagination.ts
│   └── book.ts
├── reducers
│   └── book.reducer.ts
├── services
│   ├── book.service.ts
│   └── index.ts
└── translations
    ├── es
    │   ├── book.ts
    │   └── index.ts
    └── es.ts
```

## Tests

To execute the packages tests, go to the package `app/Containers/Crud` folder and execute:

```bash
codecept run functional
```

Here are some quick data to test the generated Angular 2 create/update components from the functional tests:

```javascript
this.bookForm.patchValue({
  reason_id: 1,
  name: 'Foo',
  author: 'Bar',
  genre: 'thriller',
  stars: 3,
  published_year: '2012-12-12',
  enabled: true,
  status: 'waiting_confirmation',
  unlocking_word: 'foo',
  unlocking_word_confirmation: 'foo',
  synopsis: 'text'
});
```