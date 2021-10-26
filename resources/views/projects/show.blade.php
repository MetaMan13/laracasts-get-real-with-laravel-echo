<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
</head>
<body class="text-gray-500">
    <div id="app">
        <div class="min-h-screen w-full bg-gray-50">
            <div class="bg-white flex justify-between items-center px-6 py-4 border-b border-gray-100">
                <div>
                    <div>
                        <h3 class="font-semibold animate-pulse">Laravel Echo</h3>
                    </div>
                </div>
                <div class="flex gap-4 items-center">
                    @auth
                        <div>
                            <p class="text-sm">{{ auth()->user()->name }}</p>
                        </div>
                        <div>
                            <form action="{{ route('logout') }}">
                                @csrf
                                @method('POST')
    
                                <button type="submit" class="text-sm hover:text-green-500">Logout</button>
                            </form>
                        </div>
                    @else
                        <div>
                            <a href="{{ route('login') }}">Login</a>
                        </div>
                        <div>
                            <a href="{{ route('register') }}">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
    
            <div class="w-full flex flex-col items-center">
                <div class="text-center py-10 bg-white w-full border-b border-gray-100 shadow-sm">
                    <h3 class="text-2xl">{{ $project->name }} Tasks</h3>
                </div>
                <div class="w-1/2 bg-white text-center mt-6 py-4 rounded-md shadow-sm border-b border-gray-100">
                    <div>
                        <p class="font-base text-xl">Create new task</p>
                    </div>
                    <div class="flex flex-col items-center justify-center mt-8">
                        <input v-model="newTask" type="text" class="border border-gray-200 rounded-md p-2 focus:border-gray-300 focus:ring-transparent">
                        <button @click="createTask" class="text-base mt-4 bg-green-500 hover:bg-green-600 hover:font-semibold px-14 py-2 text-white rounded-md">Create task</button>
                    </div>
                </div>
                <div class="w-1/2 mt-6">
                    <ul v-for="task in tasks">
                        <li v-text="task" class="mb-4 bg-white text-center py-2 rounded-md border border-gray-100 shadow-sm"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script>
        let app = new Vue({
            el: '#app',
            data(){
                return{
                    tasks: [],
                    newTask: null,
                    projectId: null,
                }
            },
            created(){
                let projectId = window.location.href.split('/', 5)[4]

                this.projectId = projectId;

                axios.get('/api/projects/' + this.projectId)
                    .then((response) => {
                        this.tasks = response.data
                    })
                
                // Listen on a public channel
                // window.Echo.channel('tasks' + this.projectId).listen('TaskCreated', e => {
                //         console.log(e);
                //         this.tasks.push(e.task.body);
                //     });

                // Listen on a private channel
                window.Echo.private('tasks.' + this.projectId).listen('TaskCreated', e => {
                        console.log(e);
                        this.tasks.push(e.task.body);
                    });
            },
            methods: {
                createTask(){
                    axios.post('/api/projects/' + this.projectId + '/tasks', {body: this.newTask})
                        .then((response) => {
                            this.tasks.push(response.data)
                            this.newTask = null
                        })
                }
            }
        })
    </script>
</body>
</html>