Route::put(
    '/books/restore/{books}',
    [
    'as' => 'books.restore',
    'uses' => 'BookController@restore',
    ]
);
Route::resource('books', 'BookController');