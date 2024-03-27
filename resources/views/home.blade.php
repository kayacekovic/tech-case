@extends('layouts.app')
@section('content')
    <div id="app">
        <div class="max-w-5xl mx-auto">
            <div class="flex items-center gap-8">
                <div class="min-w-[320px]">
                    <label for="sprint" class="block text-sm font-medium leading-6 text-gray-900">Sprint</label>
                    <select id="sprint" v-model="selectedSprintId" @change="getTasks()" class="mt-2 block max-w-xs w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <option value="">All</option>
                        <template v-for="sprint in sprints">
                            <option :value="sprint.id" v-texT="sprint.title"></option>
                        </template>
                    </select>
                </div>
                <div class="min-w-[320px]">
                    <label for="sprint" class="block text-sm font-medium leading-6 text-gray-900">Developer</label>
                    <select id="sprint" v-model="selectedDeveloperId" @change="getTasks()" class="mt-2 block max-w-xs w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <option value="">All</option>
                        <template v-for="developer in developers">
                            <option :value="developer.id" v-text="developer.name"></option>
                        </template>
                    </select>
                </div>
            </div>
            <dl class="mt-5 grid grid-cols-1 lg:gap-x-8 gap-x-4 sm:grid-cols-3">
                <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                    <dt class="truncate text-sm font-medium text-gray-500">Total Tasks</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900" v-text="stats.tasks_count"></dd>
                </div>
                <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                    <dt class="truncate text-sm font-medium text-gray-500">Total Assigned Tasks</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900" v-text="stats.assigned_tasks_count"></dd>
                </div>
                <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                    <dt class="truncate text-sm font-medium text-gray-500">Estimated All Tasks Due Date</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900" v-text="stats.estimated_all_tasks_due_date"></dd>
                </div>
            </dl>
        </div>

        <div class="mt-10 flex justify-center max-w-5xl mx-auto">
            <div class="task-list">
                <template v-for="task in tasks">
                    <div class="task-card">
                        <div class="flex justify-between text-sm text-gray-600 font-medium">
                            <div v-text="`#${task.id}`"></div>
                            <div v-text="task.sprint?.title"></div>
                        </div>
                        <p class="mt-2 text-gray-700 font-semibold font-sans tracking-wide text-sm" v-text="task.title"></p>
                        <div class="flex flex-wrap justify-between gap-2 mt-3 text-sm text-gray-600">
                            <div>
                                <span class="font-medium text-gray-500">Difficulty: </span>
                                <span v-text="task.difficulty"></span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <span v-text="`${task.duration}hr`"></span>
                            </div>
                        </div>
                        <div class="flex mt-2 justify-between items-center text-sm text-gray-600">
                            <div class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                </svg>
                                <span v-text="task.humanized_due_date"></span>
                            </div>

                            <div class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <span class="text-sm text-gray-600 font-medium" v-text="task.developer?.name"></span>
                            </div>
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
                    sprints: [],
                    selectedSprintId: '',

                    developers: [],
                    selectedDeveloperId: '',

                    stats: {},
                    tasks: [],
                }
            },
            mounted() {
                this.getSprints();
                this.getDevelopers();

                this.getTasksStats();
                this.getTasks();
            },
            methods: {
                async getSprints() {
                    this.sprints = (await axios.get('/api/v1/sprints')).data.data;
                },
                async getDevelopers() {
                    this.developers = (await axios.get('/api/v1/developers')).data.data;
                },
                async getTasks() {
                    let query = `sprint_id=${this.selectedSprintId}`;
                    query += `&developer_id=${this.selectedDeveloperId}`;

                    this.tasks = (await axios.get(`/api/v1/tasks?${query}`)).data.data;
                },
                async getTasksStats() {
                    this.stats = (await axios.get('/api/v1/tasks/stats')).data;
                },
            }
        }).mount('#app')
    </script>
@endpush
