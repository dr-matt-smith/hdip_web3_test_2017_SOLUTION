
## version 9 - remove duplicated HTML with Twig inheritance

1. create a base page Twig template `/templates/_base.html.twig`

    Note we are defining a `pageTitle` block and a `main` block

        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>MGW - {% block pageTitle %}{% endblock %}</title>
            <style>
                @import 'css/style.css';
            </style>
        </head>

        <body>
        <a href="/">home</a>
        <hr>

        {% block main %}
        {% endblock %}

        </body>
        </html>

1. refactor `index.html.twig` to extend the template and override the two blocks:

        {% extends '_base.html.twig' %}

        {% block pageTitle %}home page{% endblock %}

        {% block main %}

        <h1>Welcome - home page of great detectives Book website</h1>

        <p>
            All you need to know about the best detective books
        </p>

        <ul>
            <li>
                <a href="/list">list all great books</a>
            </li>
        </ul>

        {% endblock %}

1. refactor `list.html.twig` to extend the template and override the two blocks:

        {% extends '_base.html.twig' %}

        {% block pageTitle %}list page{% endblock %}

        {% block main %}

        <h1>Great Detective Books</h1>

        <table>
            {% for book in books %}
               <tr>
                    <td>{{ book.title }}</td>
                    <td><img src="/images/{{ book.image }}"></td>
               </tr>
            {% endfor %}
        </table>

        {% endblock %}