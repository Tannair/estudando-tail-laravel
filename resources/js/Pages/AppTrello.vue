<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Studying VUE with Trello Copy
            </h2>
        </template>        

        <div class="py-2">
            <div class="container mx-auto ">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex flex-wrap sm:px-4 lg:px-6">
                    <div class="my-3.5 mb-3 sm:mb-3 md:flex items-start md:w-full lg:w-full">
                        <div 
                            v-for="card in cards" :key="card.id" 
                            class="bg-gray-200 w-1/2 mx-3.5 rounded-md shadow p-2"
                        >
                            <h2 class="mb-3 px-3.5 py-3">
                                {{card.name}}
                            </h2>
                            
                            <Container 
                                group-name="trello" 
                                @drag-start="handleDragStart(card, $event)" 
                                @drop="handleDrop(card.name, card, $event)"
                                :drop-placeholder="{ className: 'classTeste' }"
                                :get-child-payload="getChildPayload"
                            >
                                <Draggable class="dragArea" v-for="(task, index) in card.tasks" :key="index">
                                    <Card class="my-3.5">

                                        <input type="hidden" class="inputOrders" :name="'orders[' + card.name + '][]'" v-model=task.id :data-task="card.name">

                                        <div class="float-right -mb-28" v-if="task.editable">
                                            <a @click="closeInput(card, index)" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-blue-800" href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </a>
                                        </div>    

                                        <span v-if="!task.editable">{{task.title}}</span>
                                        <input
                                            ref="task" 
                                            type="text" 
                                            v-if="task.editable" 
                                            v-model="task.title" 
                                            @keypress="saveTask(task, $event)" 
                                            placeholder="Press enter to save..." 
                                            class="border border-transparent focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent focus:rounded w-4/5 text-sm"
                                        >

                                        <div class="float-right" v-if="!task.editable">
                                            <a @click="deleteTask(card, index, task)" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-blue-800" href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        </div>

                                        <div class="float-right" v-if="!task.editable">
                                            <a @click="task.editable = true;" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-blue-800" href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        </div>                                        
                                        
                                    </Card>
                                </Draggable>                    
                            </Container>            

                            <button v-if="!card.new" @click="showForm(card)" class="bg-transparent hover:bg-gray-300 text-gray-400 font-semibold py-2 px-4 border hover:border-transparent rounded w-full inline-flex items-center">
                                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span>Add a card</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>

</template>

<script>
import Card from '@/Trello/Card';
import Header from '@/Trello/Header';
import AppLayout from '@/Layouts/AppLayout.vue';


import { Inertia }  from '@inertiajs/inertia';
import { Container, Draggable } from "vue3-smooth-dnd";
import axios from 'axios';
import jQuery from 'jquery';

export default {
    name: 'App',
    components: {
        Header,
        Card,
        Container,
        Draggable,
        AppLayout
    },
    props: {
        cards: Object,
        next_orders: Object
    },
    data: () => ({
        draggingCard: {
            lane: '',
            index: -1,
            cardData: {}
        },
        cardVals: {
            id: false,
            title: false
        },
        dropPlaceStyle: {
            className: 'classTeste'
        },
    }),
    
    methods: {

        async saveTask( task, event )
        {
            if (event.key == "Enter" && !event.shiftKey) 
            {
                this.makeRequest('/trello', task);
            }
        },

        closeInput( card, task_index )
        {
            if (card.new && !card.tasks[task_index].id) 
            {
                this.deleteTask(card, task_index );
            }

            card.tasks[task_index].editable = false;
        },

        deleteTask( card, task_index, task_id = false )
        {
            card.tasks.splice(task_index, 1);

            if ( task_id ) 
            {
                this.makeRequest('/trello', { id: task_id, delete: true });
            }

            card.new = false;
        },

        showForm(card) {

            card.tasks.push({
                title: '',
                editable: true,
                stage_id: card.id,
                order: this.next_orders[card.name] 
            });

            card.new = true;  
            
            // this.nextTick(() => {
            //     this.focusInput();
            // });
        },

        // focusInput() {
        //     this.$refs.task.focus();
        // },

        async saveOrders ()
        {
            let element = {}, data = [];

            jQuery.each(this.cards, function (key, card) {
                let tasks = card.tasks;

                jQuery.each(tasks, function(i, task) {

                    element = {}
                    element.card = card.id;
                    element.task = task.id;

                    data.push(element);

                });               

            });

            this.makeRequest('/orders', { cards: data }, false);
        },

        async makeRequest( url, data, reload = true )
        {            
            console.log('insidee request' + data);

            axios.post(url, data);
            //let response = await this.$inertia.post(url, data);

            if (reload) 
            {
                Inertia.reload(['cards', 'next_orders']);
            }
        },

        handleDragStart(card, dragResult) {
            const { payload, isSource } = dragResult;

            if (isSource) 
            {
                this.draggingCard = {
                    lane: card.name,
                    index:payload.index,
                    cardData: {
                        ...card.tasks[payload.index]
                    }
                }
            }
        },
        handleDrop(lane, card, dropResult)
        {
            const { addedIndex, removedIndex } = dropResult; 

            if ( (lane === this.draggingCard.lane && removedIndex === addedIndex) || (addedIndex == undefined && removedIndex == undefined) ) {
                return;
            }

            if ( removedIndex !== null ) 
            {
                card.tasks.splice(removedIndex, 1);
            }

            if ( addedIndex !== null ) 
            {
                card.tasks.splice(addedIndex, 0, this.draggingCard.cardData);
            }

            this.saveOrders();
            
        },
        getChildPayload(index) {
            return {
                index
            };
        }
    }   
}
</script>

<style>

    .classTeste {
        background: green;
    }
    
</style>