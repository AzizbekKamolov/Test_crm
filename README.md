# Getting started

## Installation

Clone the repository

    git clone https://github.com/AzizbekKamolov/Test_crm.git

Switch to the repo folder

    cd Test_crm

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate
    
Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate --seed

Start the local development server

    php artisan serve
