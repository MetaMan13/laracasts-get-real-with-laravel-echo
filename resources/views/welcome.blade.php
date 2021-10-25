<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    </head>
    <body class="antialiased">

        <div id="app">
            <div>
                <h3>Create Task</h3>
                <input type="text" v-model="newTask" @blur="addTask">
            </div>

            <div>
                <h3>Tasks</h3>
                <ul>
                    <li v-for="task in tasks" v-text="task"></li>
                </ul>
            </div>
        </div>

        <script src="{{ asset('/js/app.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>

        <script>
            let app = new Vue({
                el: '#app',
                data: {
                    tasks: null,
                    newTask: null,
                },
                created(){
                    axios
                        .get('/tasks')
                        .then((response) => {
                            this.tasks = response.data
                        });

                    window.Echo.channel('tasks').listen('TaskCreated', e => {
                        console.log('New task has been created by someone!');

                        this.tasks.push(e.task.body);
                        console.log(e);
                    });
                },
                methods: {
                    addTask(){
                        axios.post('/tasks', {body: this.newTask})

                        this.tasks.push(this.newTask);

                        this.newTask = null;
                    },
                }
            })
        </script>
    </body>
</html>
