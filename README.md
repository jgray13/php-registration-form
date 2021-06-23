# php-registration-system

First, I created a MySQL database named users. A table named users is created inside the database with the users.sql file. Connection to the database is made with the config file. The config file is required in the Registration and Login pages.

The Registration page contains an HTML form with inputs for username, email, password and password confirmation. The input is validated with PHP, an error message is displayed for empty or invalid fields on submission of the form.

After successful registration, redirect to the Login page which contains a simple HTML form with inputs for username and password. Inputs are validated, an error message is displayed for empty/invalid fields. The inputs are verified with the database record. After successful login, redirect to Welcome page.

The welcome page displays a greeting and a logout button if the username is set, or a link to login if the username is not set.

A session is started on the login page, session variables are set on successful login. When logged in, the Welcome page contains a link to the Logout page, where the session is destroyed.
