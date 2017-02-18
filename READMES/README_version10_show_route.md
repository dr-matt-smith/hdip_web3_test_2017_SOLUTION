
## version 10 - add show one book route

1. refactor`/templates/list.html.twig` so that a link to the show page for the book's ID is wrapped around the title text:

        <tr>
            <td><a href="/show/{{ book.id }}"> {{ book.title }}</a></td>
            <td><img src="/images/{{ book.image }}"></td>
        </tr>

1. add a show route to the WebApplication routes list, passing the ID as a parameter:

        $this->get('/', 'main.controller:indexAction');
        $this->get('/list', 'main.controller:listAction');
        $this->get('/show/{id}', 'main.controller:showAction');

1. write a Twig template page to show one book `show.html.twig`:

        {% extends '_base.html.twig' %}

        {% block pageTitle %}list page{% endblock %}

        {% block main %}

        <h1>One Detective Books</h1>

        <h2>{{ book.title }}</h2>
        <p><strong>total pages</strong> {{ book.numPagesTotal }}</p>
        <p><img src="/images/{{ book.image }}"></p>

        {% endblock %}

1. add a `showAction()` method to `MainController`:

        public function showAction($id)
        {
            // get reference to our repository
            $bookRepository = new BookRepository();
            $book = $bookRepository->getOneByById($id);

            $argsArray = [
                'book' => $book
            ];
            $templateName = 'show';
            return $this->app['twig']->render($templateName . '.html.twig', $argsArray);
        }