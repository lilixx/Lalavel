

<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.5/vue.min.js"></script>

<script src="https://cdn.jsdelivr.net/vue.resource/1.2.1/vue-resource.min.js"></script>
<!-- Jquery -->
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

@extends('layouts.app')

@section('content')

@verbatim
  <div id="todo-list-example">
    <input
      v-model="newTodoText"
      v-on:keyup.enter="addNewTodo"
      placeholder="Add a todo"
    >
    <ul>
      <li
        is="todo-item"
        v-for="(todo, index) in todos"
        v-bind:key="todo"
        v-bind:title="todo"
        v-on:remove="todos.splice(index, 1)"
      ></li>
    </ul>
  </div>
@endverbatim
        <script type="text/javascript">

                    Vue.component('todo-item', {
        template: `
          <li>

            <button v-on:click="$emit('remove')">X</button>
          </li>
        `,

      })
      new Vue({
        el: '#todo-list-example',
        data: {
          newTodoText: '',
          todos: [
            'Do the dishes',
            'Take out the trash',
            'jajajaja',
            'Mow the lawn'
          ]
        },
        methods: {
          addNewTodo: function () {
            this.todos.push(this.newTodoText)
            this.newTodoText = ''
          }
        }
      })
                    </script>
@endsection
