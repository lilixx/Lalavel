<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

              <div id="app">
{{ message }}
</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
var app = new Vue({
  el: '#app',
  data: {
    message: 'Hello Vue!'
  }
})
</script>
