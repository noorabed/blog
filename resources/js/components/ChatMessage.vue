<template>
    <div class="chat-message">
        <p>{{message.user.name}}</p>
        <p>{{message.message}}</p>

    </div>
</template>

<script>
    export default {
       props:['message']
    }
</script>
<style>
    .chat-message{
        padding:1rem;
    }
    .chat-message > p{
       margin-bottom: 1rem;
    }
</style>