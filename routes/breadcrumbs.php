<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Statistics', route('showHome'));
});

// Categories
Breadcrumbs::for('categories', function ($trail) {
    $trail->push('List of categories', route('showCategories'));
});
Breadcrumbs::for('addCategory', function ($trail) {
    $trail->parent('categories');
    $trail->push('Add a category', route('showAddCategory'));
});

Breadcrumbs::for('showCategory', function ($trail, $category) {
    $trail->parent('categories');
    $trail->push($category->name);
});
Breadcrumbs::for('updateCategory', function ($trail, $category) {
    $trail->parent('categories');
    $trail->push('Update a a category');
    $trail->push($category->name);
});

// Books
Breadcrumbs::for('books', function ($trail) {
    $trail->push('List of books', route('showBooks'));
});
Breadcrumbs::for('addBook', function ($trail) {
    $trail->parent('books');
    $trail->push('Add a book', route('showAddBook'));
});

Breadcrumbs::for('showBook', function ($trail, $book) {
    $trail->parent('books');
    $trail->push($book->title);
});
Breadcrumbs::for('updateBook', function ($trail, $book) {
    $trail->parent('books');
    $trail->push('Update a book');
    $trail->push($book->title);
});

//Articles

Breadcrumbs::for('articles', function ($trail) {
    $trail->push('List of articles', route('showArticles'));
});

Breadcrumbs::for('showAddArticle', function ($trail) {
    $trail->parent('articles', route('showArticles'));
    $trail->push('add an article');
});

Breadcrumbs::for('showArticle', function ($trail, $article) {
    $trail->parent('articles');
    $trail->push($article->title);
});

Breadcrumbs::for('updateArticle', function ($trail, $article) {
    $trail->parent('articles');
    $trail->push('Update an article');
    $trail->push($article->title);
});

//Users

Breadcrumbs::for('users', function ($trail) {
    $trail->push('List of users', route('showUsers'));
});

Breadcrumbs::for('showAddUser', function ($trail) {
    $trail->parent('users');
    $trail->push('Add a user');
});

Breadcrumbs::for('showUser', function ($trail, $user) {
    $trail->parent('users');
    $trail->push($user->formatName());
});

Breadcrumbs::for('updateUser', function ($trail, $user) {
    $trail->parent('users');
    $trail->push('Update a user');
    $trail->push($user->formatName());
});

//

//Authors

Breadcrumbs::for('authors', function ($trail) {

    $trail->push('Liste of authors', route('showAuthors'));
});
Breadcrumbs::for('showAddAuthor', function ($trail) {
    $trail->parent('authors');
    $trail->push('Add an author');
});
Breadcrumbs::for('showAuthor', function ($trail, $author) {
    $trail->parent('authors');
    $trail->push($author->fullName());
});

Breadcrumbs::for('showUpdateAuthor', function ($trail, $author) {
    $trail->parent('authors');
    $trail->push('Update an author');
    $trail->push($author->fullName());
});

//Notifications

Breadcrumbs::for('sendNotification', function ($trail) {

    $trail->push('Send notification', route('showSendNotification'));
});

//Collections

Breadcrumbs::for('collections', function ($trail) {

    $trail->push('Liste of collections', route('showCollections'));
});
Breadcrumbs::for('addCollection', function ($trail) {
    $trail->parent('collections');
    $trail->push('Add an collection');
});
Breadcrumbs::for('showCollection', function ($trail, $collection) {
    $trail->parent('collections');
    $trail->push(ucfirst($collection->name));
});

Breadcrumbs::for('updateCollection', function ($trail, $collection) {
    $trail->parent('collections');
    $trail->push('Update a collection');
    $trail->push(ucfirst($collection->name));
});

// Breadcrumbs::for('showOrder', function ($trail, $order) {
//     $trail->parent('orders');
//     $trail->push($order->code);
// });

// //Reviews

// Breadcrumbs::for('reviews', function ($trail) {

//     $trail->push('Liste des avis', route('showReviews'));
// });

// //Supports

// Breadcrumbs::for('supports', function ($trail) {

//     $trail->push('Liste des demandes', route('showSupports'));
// });

// Breadcrumbs::for('showSupport', function ($trail, $support) {
//     $trail->parent('supports');
//     $trail->push($support->user->formatName());
// });
