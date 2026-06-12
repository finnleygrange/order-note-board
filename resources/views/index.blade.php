<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <title>Order Note Board</title>
</head>
<body>
    <div id="app">
        <h2>Order Note Board</h2>
        
        <form @submit.prevent="save">
            <label for="order_number">Order Number</label><br>
            <input type="text" v-model="form.order_number" required><br>

            <label for="message">Message</label><br>
            <input type="text" v-model="form.message" required><br>

            <label for="author">Author</label><br>
            <input type="text" v-model="form.author" required><br><br>

            <button type="submit">Save Note</button>
        </form>

        <div id="notes">
            <h3>Notes:</h3>
            <p v-for="n in notes">
                Order: @{{n.order_number}} - @{{n.message}} (@{{n.author}})
            </p>
        </div>
    </div>

    <script>
        Vue.createApp({
            setup() {
                const notes = Vue.ref([]);
                const form = Vue.ref({});

                const getNotes = () => {
                    fetch('/api/notes')
                        .then(res => res.json())
                        .then(data => notes.value = data);
                };

                const save = () => {
                    fetch('/api/notes', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(form.value)
                    }).then(() => {
                        form.value = {};
                        getNotes();
                    });
                };

                Vue.onMounted(getNotes);

                return { notes, form, save };
            }
        }).mount('#app');
    </script>
</body>
</html>