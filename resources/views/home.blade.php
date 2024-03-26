@extends('layouts.app')
@section('content')
    <div id="app">
        <div class="flex justify-center">
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
                                        <div class="flex flex-wrap gap-2 mt-3">
                                            Difficulty / Duration
                                        </div>
                                        <div class="flex mt-2 justify-between items-center">
                                            <span class="text-sm text-gray-600" v-text="task.humanized_created_at"></span>

                                            <span class="text-sm text-gray-600" v-text="task.developer?.name"></span>
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

                for (let task in tasks) {
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
