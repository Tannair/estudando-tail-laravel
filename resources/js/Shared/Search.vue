<template>
    <div class="mx-20 my-10">
        <form @submit.prevent="onSubmit" class="mb-4 w-full sm:w-2/3 md:w-1/3 ">
            <label for="search" class="block text-sm font-medium text-gray-700">
                Search Breweries
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
            <div class="relative flex items-stretch flex-grow focus-within:z-10">
                <div
                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                >
                <svg
                    class="h-5 w-5 text-gray-400"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                <path
                    fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd"
                />
                </svg>
                </div>
                <input
                    v-model="searchTerm"
                    type="search"
                    name="search"
                    id="search"
                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none rounded-l-md pl-10 sm:text-sm border-gray-300"
                    placeholder="Type here..."
                />
            </div>
            <button
                type="submit"
                class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
            >
                <span>Search</span>
            </button>
            </div>
        </form>
    </div>    
</template>

<script>
export default {
  name: "Search",
  methods: {
        onSubmit() {
            this.$inertia.replace(
                this.route('brewery', { search: this.searchTerm })
            );
        }
    }
//   props: {
//     data: Object,
//   },
};
</script>