<template>
    <search />
    <div class="mx-20 my-10 shadow overflow-hidden sm:rounded-md">
        <div class="max-w-sm w-full lg:max-w-full lg:flex">
            <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('/img/card-left.jpg')" title="Woman holding a mug">
            </div>
            <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                <div class="mb-8">
                <p class="text-sm text-gray-600 flex items-center">
                    <svg class="fill-current text-gray-500 w-3 h-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M4 8V6a6 6 0 1 1 12 0v2h1a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h1zm5 6.73V17h2v-2.27a2 2 0 1 0-2 0zM7 6v2h6V6a3 3 0 0 0-6 0z" />
                    </svg>
                    Members only
                </p>
                <div class="text-gray-900 font-bold text-xl mb-2">Can coffee make you a better developer?</div>
                    <p class="text-gray-700 text-base">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.</p>
                </div>
                <div class="flex items-center">
                    <img class="w-10 h-10 rounded-full mr-4" src="/img/tanair.jpg" alt="Avatar of Jonathan Reinink">
                    <div class="text-sm">
                        <p class="text-gray-900 leading-none">Tanair Oliveira</p>
                        <p class="text-gray-600">Aug 18</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mx-20 my-10 bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            <li v-for="b in breweries.data" :key="b.id">
                <inertia-link 
                    :href="route('brewery.beers', { id: b.id })" 
                    class="block hover:bg-gray-50"
                >
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-indigo-600 truncate">
                                {{ b.name }}
                            </p>
                            <div class="ml-2 flex-shrink-0 flex">
                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Open NOW! 🍺
                                </p>
                            </div> 
                        </div>
                        <div class="mt-2 sm:flex sm:justify-between">
                            <div class="sm:flex">
                                <p class="mt-2 flex items-center text-sm text-gray-500">
                                    <!-- Heroicon name: solid/location-marker -->
                                    <svg
                                        class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                        fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"
                                        />
                                    </svg>
                                    {{ b.city }}, {{ b.state }} - {{ b.country }}
                                </p>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                <p>Quantidade de cervejas: {{ b.beers_count }}</p>
                            </div>
                        </div>
                    </div>
                </inertia-link>
            </li>
        </ul>
        <div v-if="!shouldHidePagination" class="px-6 pb-4">
            <pagination :data="breweries" />
        </div>
    </div>
</template>
<script>
import Search from "../Shared/Search.vue";
import Pagination from "../Shared/Pagination.vue";

export default {
    name: "Beer Dashboard",
    components: { Pagination, Search },
    props: {
        breweries: Object, 
    },    
    data() {
        return {
            searchTerm: ''
        }
    },
    computed: {
        shouldHidePagination() {
            return !this.breweries.prev_page_url && !this.breweries.next_page_url;
        }
    }
}
</script>

