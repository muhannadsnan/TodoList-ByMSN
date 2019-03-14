<template>
    <div class="Todo d-flex">

        <div class="list-group col-md-4">
            <div class="add-todo d-flex pl-0 mb-2">
                <input type="text" class="form-control" placeholder="Add todo..."
                        data-container="body" data-toggle="popover" data-placement="top" data-content="Press enter!"
                        @keyup.enter="onKeyEnterAddTodo()"
                        v-model="newTodo.title" :disabled="loading.todos">
            </div>
            <h6 href="#" v-for="(todo, i) in todos" :key="i"
                    class="list-group-item list-group-item-action d-flex border-dark" 
                    :class="{'active': selectedTodo === todo, 'disabled': loading.todos}"
                    @click="selectTodo(todo)">
                <i class="far fa-trash-alt mr-4" @click="onDelItem(item)"></i>
                {{todo.title}}
            </h6>
        </div>
        <div v-if="todos.length == 0" class="col-md-8"> 
            <div class="alert alert-info">please add a todo..</div>
        </div>
        <div v-else class="col-md-8"> <!-- show todos -->

            <div v-if="selectedTodo === null"> 
                <div class="alert alert-info">click on a list</div>
            </div>
            <div v-else class="Items">
                    <div class="loading" v-if="loading.items">
                        <h5 class="text-center w-100 mt-5 mb-4">Loading items... </h5>
                        <p class="text-center w-100"><i class="fa fa-cog fa-spin fa-3x fa-fw"></i></p>
                    </div>
                    <div v-else>
                        <div class="add-item d-flex pl-0 mb-2">
                            <input type="text" class="form-control" placeholder="Add item..."
                                    data-container="body" data-toggle="popover" data-placement="top" data-content="Press enter!"
                                    @keyup.enter="onKeyEnterAddItem()"
                                    v-model="newItem.title">
                        </div>
                        <div v-if="items.length == 0">
                            <div class="alert alert-info">please add items to the todo list "{{selectedTodo.title}}"</div>
                        </div>
                        <div v-else>
                        <div class="card border-primary mb-2" v-for="(item, i) in items" :key="i">
                            <div class="card-body d-flex justify-content-between">
                                <i class="far fa-trash-alt fa-2x" @click="onDelItem(item)"></i>
                                <h5 class="card-title" :class="{'complete': item.complete}" 
                                    @dblclick="onDblClick(item)" v-if="editMode != item.id">{{item.title}}</h5>  
                                <input type="text" v-if="editMode == item.id" class="form-control col-md-8" :value="item.title" @keyup.enter="onKeyEnterTitleEdit(item)">  
                                <i class="far fa-2x" :class="{'fa-check-square': item.complete, 'fa-square': !item.complete}"
                                    @click="toggleComplete(item)"></i>
                            </div>
                        </div>
                    </div>            
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["todos"],
        data() {
            return {
                editMode: false,
                selectedTodo: null,
                newTodo: {title: ''},
                newItem: {title: '', complete: false},
                items: [],
                loading: {todos: false, items: false}
            }
        },
        methods: {
            selectTodo(todo){
                this.selectedTodo = todo
            },
            getItems(){
                var arr = [
                    {id: 1, title: 'item #1', complete: false, todo_id: 1},
                    {id: 2, title: 'item #2', complete: true, todo_id: 1},
                    {id: 3, title: 'item #3', complete: true, todo_id: 3},
                    {id: 4, title: 'item #4', complete: false, todo_id: 3},
                    {id: 5, title: 'item #5', complete: false, todo_id: 3},
                    {id: 6, title: 'item #6', complete: false, todo_id: 2},
                    {id: 7, title: 'item #7', complete: false, todo_id: 1},
                ];
                this.items = arr.filter(el => el.todo_id == this.selectedTodo.id)
            },
            getItemsDebounced: _.debounce(function(){ this.getItems() }, 200),
            toggleComplete(item){
                axios.put('')
                    .then(response => {
                        item.complete = !item.complete                        
                    })
                    .catch(error => console.log(error))
            },
            onDelItem(item){
                if(confirm('Are you sure to delete item: '+item.title)){

                }
            },
            onDblClick(item){
                this.editMode = item.id
            },
            onKeyEnterTitleEdit(item){
                this.editMode = false
            },
            onKeyEnterAddTodo(){
                this.todos.unshift({title: this.newTodo.title})
                this.newTodo = {title: ''}
            },
            onKeyEnterAddItem(){
                this.items.unshift({title: this.newItem.title, complete: false})
                this.newItem = {title: '', complete: false}
            }
        },
        watch: {
            selectedTodo: {
                handler: function(newValue) {
                    this.getItemsDebounced()
                },
                deep: true
            }
        },
        created() {
            console.log('Todo component mounted.')
            this.todos = []
        }
    } 
</script>

<style lang="scss" scoped>
.Todo{
    *.disabled{cursor: not-allowed; color: #aaa}
    min-height: 800px;
    .fa-trash-alt:hover{
        color: #dc3545;
    }
    .far{
        cursor: pointer;
    }
    .list-group-item{
        cursor: pointer;
    }
    .Items{
        .card{
            .card-body{
                h5{
                    margin-bottom: 0 !important; 
                }  
                .complete{
                    text-decoration: line-through;
                }              
            }
        }
    }
}
</style>

