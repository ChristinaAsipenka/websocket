<template>
    <div class="w-1/2 mx-auto py-6">
        <div>
            <div class="mb-4">
                <input type="text" v-model="body" placeholder="Message" class="rounded-full border border-gray-300">
            </div>
            <div class="mb-4">
                <button @click="store" class="rounded-lg block w-48 bg-sky-400 text-white text-center py-2">Send</button>
            </div>
        </div>
        <div v-if="messages.length > 0" class="mb-4">
            <h3>Messages</h3>
            <div class="pt-4">
                <div v-for="message in messages" class="text-sm pb-2 mb-2 border-b-2">
                    <p>{{ message.id }}</p>
                    <p>{{ message.body }}</p>
                    <p class="text-right">{{ message.time }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "index",
    props: ["messages"],
    data() {
        return {
            body: ''
        }
    },

    created() {
      window.Echo.channel('public_store_message')
          .listen('.public_store_message', response => {
              console.log(response)
          })
    },

    methods: {
        store() {
            axios.post("/messages", {body: this.body})
                .then(response => {
                    this.messages.unshift(response.data)
                    this.body = ''
                })
        }
    }
}
</script>

<style scoped>

</style>
