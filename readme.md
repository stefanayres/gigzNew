# Connecting people and places.

## Introduction

> An introduction or lead on what problem you're solving. Answer the question, "Why does someone need this?"

## Code Samples


    ..Main end points for access..
    Route::post('login', 'ApiController@login');
    Route::post('register', 'ApiController@register');
    Route::get('details', 'ApiController@details');
    Route::get('show', 'ApiController@showAllUsers');

## Installation

<h4>Follow this to set up peoject on local computer </h4>

> - git clone linktogithubrepo.com/ projectName


>- cd projectName


>- Composer install


>- cp .env.example .env


>- php artisan key:generate


>- In the .env file fill in the DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD.


>-  php artisan migrate


>-  jwt generate:secret


<h4>After this is complete open a the terminal/cmd in the root directory of the project.
From here run <code>php artisan serve</code>  and enjoy. </h4>
