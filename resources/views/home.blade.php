@extends('layouts.app')
@section('content')
    <div id="app">
        <div class="max-w-5xl mx-auto">
            <div>
                <label for="sprint" class="block text-sm font-medium leading-6 text-gray-900">Sprint</label>
                <select id="sprint" class="mt-2 block max-w-xs w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    <option selected>All</option>
                    <option>WYGN 1</option>
                    <option>WYGN 2</option>
                </select>
            </div>
            <dl class="mt-5 grid grid-cols-1 lg:gap-x-8 gap-x-4 sm:grid-cols-3">
                <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                    <dt class="truncate text-sm font-medium text-gray-500">Total Tasks</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">71,897</dd>
                </div>
                <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                    <dt class="truncate text-sm font-medium text-gray-500">Total Sprints</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">58.16%</dd>
                </div>
                <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                    <dt class="truncate text-sm font-medium text-gray-500">Estimated All Tasks Due Date</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">24.57%</dd>
                </div>
            </dl>
        </div>

        <div class="mt-10 flex justify-center">
            <div class="flex justify-between overflow-x-scroll lg:gap-x-8 gap-x-4">
                <template v-for="column in columns">
                    <div class="task-column">
                        <p class="text-gray-700 font-semibold font-sans tracking-wide text-sm pb-2" v-text="column.title"></p>
                        <div class="task-list">
                            <template v-for="task in column.tasks">
                                <div class="task-card">
                                    <div>
                                        <div class="flex justify-between">
                                            <p class="text-gray-700 font-semibold font-sans tracking-wide text-sm" v-text="task.title"></p>
                                        </div>
                                        <div class="flex flex-wrap justify-between gap-2 mt-3 text-sm text-gray-600">
                                            <div>
                                                <span class="font-medium text-gray-500">Difficulty: </span>
                                                <span v-text="task.difficulty"></span>
                                            </div>
                                            <div>
                                                <span class="font-medium text-gray-500">Duration: </span>
                                                <span v-text="`${task.duration}hr`"></span>
                                            </div>
                                        </div>
                                        <div class="flex mt-2 justify-between items-center">
                                            <span class="text-sm text-gray-600" v-text="task.humanized_created_at"></span>

                                            <span class="text-sm text-gray-600 font-medium" v-text="task.developer?.name"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        const { createApp, ref } = Vue

        createApp({
            data() {
                return {
                    columns: @js(\App\Enums\TaskStatuses::getColumns()),
                }
            },
            async mounted() {
                const tasks = await this.getTasks();

                for (let task of tasks) {
                    let columnIndex = this.columns.findIndex(column => column.id === task.status);

                    this.columns[columnIndex].tasks.push(task);
                }
            },
            methods: {
                async getTasks() {
                    return (await axios.get('/api/v1/tasks')).data.data;
                }
            }
        }).mount('#app')
    </script>
@endpush
