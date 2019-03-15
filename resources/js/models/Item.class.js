export default class Item {
    constructor(id = 0, title = "", complete = false, todo_id = 0) {
        this.id = id;
        this.title = title;
        this.complete = complete; 
        this.todo_id = todo_id; 
    }
}