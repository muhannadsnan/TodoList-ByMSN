<template>
    <div class="">
        <div v-if="selectedTodo === null"> 
                <div class="alert alert-info">Click a list !!</div>
            </div>
            <div v-else class="Items">
                    <div class="loading.items" v-if="loading.items">
                        <h5 class="text-center w-100 mt-5 mb-4">loading items... </h5>
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
                            <div class="alert alert-info">No items in todo <strong>{{selectedTodo.title}}</strong>, please add items. </div>
                        </div>
                        <div v-else>
                        <div class="card border-primary mb-2" v-for="(item, i) in items" :key="i">
                            <div class="card-body d-flex justify-content-between">
                                <i class="far fa-trash-alt fa-2x" @click="onDelItem(item)"></i>
                                <h5 class="card-title" :class="{'complete': item.complete}" 
                                    @dblclick="onDblClick(item)" v-if="editMode != item.id">{{item.title}}</h5>  
                                <input type="text" v-if="editMode == item.id" class="form-control col-md-8"
                                        data-container="body" data-toggle="popover" data-placement="top" data-content="Press enter!"
                                        @keyup.enter="onKeyEnterTitleEdit(item)" v-model="updItem.title"
                                        @keyup.esc="editMode = false" :disabled="loading.item == item.id">  
                                <span class="d-flex justify-content-end">
                                    <i class="fa fa-cog fa-spin fa-2x fa-fw" v-show="loading.item == item.id"></i>
                                    <i class="far fa-2x" :class="{'fa-check-square': item.complete, 'fa-square': !item.complete}"
                                        @click="toggleComplete(item)"></i>
                                </span>
                            </div>
                        </div>
                    </div>            
                </div>
            </div>
    </div>
</template>

<script>
    import Item from '../models/Item.class';
    import Store from '../models/Store';
    export default {
        data() {
            return {
                editMode: false,
                selectedTodo: null,
                items: [],
                newItem: new Item(),
                updItem: new Item(),
                loading: {items: false, item: 0}
            }
        },
        methods: {
            getItems(){
                this.loading.items = true  
                    axios.get(`${Store.url2}/todos/${this.selectedTodo.id}/items`)
                        .then(response => {
                            console.log(response)
                            this.items = response.data.data 
                            $('.add-item input').focus();
                        })
                        .catch(error => console.log(error)) 
                        .then(() => { // finally
                            this.loading.items = false 
                        }) 
            },
            getItemsDebounced: _.debounce(function(){ this.getItems() }, 300),
            toggleComplete(item){
                this.loading.item = item.id  
                this.updItem = item
                this.updItem.complete = !this.updItem.complete
                axios.put(`${Store.url2}/items/${this.updItem.id}`, this.updItem)
                    .then(response => {
                        console.log(response)  
                        if(response.status == 200){
                            // toastr
                        }
                        else if(response.status == 400){
                            console.log(response.data) // toastr
                        }   
                    })
                    .catch(error => console.log(error)) 
                    .then(() => { // finally
                        this.loading.item = 0
                    })    
            },
            onDelItem(item){
                if(confirm('Are you sure to delete item: '+item.title)){
                    this.loading.items = true  
                    axios.delete(`${Store.url2}/items/${item.id}`)
                        .then(response => {
                            console.log(response)
                            this.items = this.items.filter(el => el.id != response.data.data.id)
                            $('.add-item input').focus()
                            toastr.success(response.data.msg)
                        })
                        .catch(error => console.log(error)) 
                        .then(() => { // finally
                            this.loading.items = false
                        })    
                }
            },
            onDblClick(item){
                this.editMode = item.id
                this.updItem = item    
            },
            onKeyEnterTitleEdit(){
                this.loading.item = this.updItem.id  
                axios.put(`${Store.url2}/items/${this.updItem.id}`, this.updItem)
                    .then(response => {
                        console.log(response)
                        this.updItem = new Item() 
                        toastr.success(response.data.msg)
                    })
                    .catch(error => {
                        if (error.response.status == 422) {  // VALIDATION ERROR
                            console.log(error.response)
                            this.updItem.title = error.response.data.data.title
                        }
                        var msg = ""
                        for (var el in error.response.data.msg) 
                            msg += error.response.data.msg[el] + '<br>' 
                        toastr.error(msg, '', {timeOut: 10000}) 
                    }) 
                    .then(() => { // finally
                        this.editMode = false
                        this.loading.item = 0
                    })
            },
            onKeyEnterAddItem(){
                this.loading.items = true  
                axios.post(Store.url2+'/items', {...this.newItem, todo_id: this.selectedTodo.id })
                    .then(response => {
                        console.log(response)
                        this.items.unshift(response.data.data)
                        this.newItem = new Item() 
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
                        this.loading.items = false
                        $('.add-item input').focus();
                    })               
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
            console.log('Component mounted.')
            this.$parent.$on('todo-selected', (todo) => this.selectedTodo = todo)
        }
    }
</script>

<style lang="scss" scoped>

</style>

