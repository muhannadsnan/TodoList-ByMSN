<template>
    <div class="Todo d-flex">

        <div class="list-group col-md-4">
            <div class="add-todo d-flex pl-0 mb-2">
                <input type="text" class="form-control" placeholder="Add todo..."
                        data-container="body" data-toggle="popover" data-placement="top" data-content="Press enter!"
                        @keyup.enter="onKeyEnterAddTodo()"
                        v-model="newTodo.title" :disabled="loading">
            </div>
            <h6 href="#" v-for="(todo, i) in todos" :key="i"
                    class="list-group-item list-group-item-action d-flex border-dark" 
                    :class="{'active': selectedTodo === todo, 'disabled': loading}"
                    @click="selectTodo(todo)">
                <i class="far fa-trash-alt mr-4" @click="onDelTodo(todo)"></i>
                {{todo.title}}
            </h6>
        </div>

        <div v-if="todos.length == 0" class="col-md-8"> 
            <div class="alert alert-info">please add a todo..</div>
        </div>
        <div v-else class="col-md-8"> <!-- show items -->
            <Items />
        </div>        
        
    </div>
</template>

<script>
    import Todo from '../models/Todo.class';
    import Store from '../models/Store';
    export default {
        props: ["todos"],
        data() {
            return {
                editMode: false,
                selectedTodo: null,
                newTodo: new Todo(),
                loading: false
            }
        },
        methods: {
            selectTodo(todo){
                this.selectedTodo = todo
            },
            onDelTodo(todo){
                if(confirm('Are you sure to delete todo: '+todo.title)){
                    this.loading = true  
                    axios.delete(Store.url2+'/todos/'+todo.id)
                        .then(response => {
                            console.log(response)
                            this.todos = this.todos.filter(el => el.id != response.data.data.id) 
                            this.selectedTodo = null
                            $('.add-todo input').focus();
                            toastr.success(response.data.msg)
                        })
                        .catch(error => { console.log(error); toastr.success(response.data.msg); }) 
                        .then(() => { // finally
                            this.loading = false
                        })    
                }
            }, 
            onKeyEnterAddTodo(){
                this.loading = true  
                axios.post(Store.url2+'/todos', this.newTodo)
                    .then(response => {
                        console.log(response)
                        this.todos.unshift(response.data.data)
                        this.selectedTodo = response.data.data
                        this.newTodo = new Todo()
                        $('.add-item input').focus();
                        toastr.success(response.data.msg)
                    })
                    .catch(error => {
                        if (error.response.status == 422) {  // VALIDATION ERROR
                            console.log(error.response) 
                        }
                        var msg = ""
                        for (var el in error.response.data.msg) 
                            msg += error.response.data.msg[el] + '<br>' 
                        toastr.error(msg, '', {timeOut: 10000}) 
                    })  
                    .then(() => { // finally
                        this.editMode = false
                        this.loading = false
                        $('.add-todo input').focus();
                    })              
            },            
        },
        watch: {
            selectedTodo: {
                handler: function(newValue) {
                    this.$emit('todo-selected', newValue)
                },
                deep: true
            }
        },
        created() {
            console.log('Todo component mounted.')
        }
    } 
</script>

<style lang="scss" scoped>

</style>

