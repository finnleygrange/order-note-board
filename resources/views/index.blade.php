<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <title>Order Note Board</title>
</head>
<body>
    <div id="app" class="container-fluid my-4">
        <h2 class="mb-4">Order Note Board</h2>
        
        <form @submit.prevent="save" class="row row-cols-lg-auto g-3 align-items-center mb-5">
            <div class="col-12">
                <input type="text" class="form-control" v-model="form.order_number" placeholder="Order Number" required>
            </div>

            <div class="col-12">
                <input type="text" class="form-control" v-model="form.message" placeholder="Message" required>
            </div>

            <div class="col-12">
                <input type="text" class="form-control" v-model="form.author" placeholder="Author" required>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Save Note</button>
            </div>
        </form>

        <div id="notes" class="pt-3 border-top">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="h5 m-0">Notes:</h3>
                <div class="w-25">
                    <input type="text" class="form-control form-control-sm" v-model="searchQuery" placeholder="Search notes...">
                </div>
            </div>

            <ul class="list-group">
                <li v-for="n in filteredNotes" class="list-group-item">
                    Order: @{{n.order_number}} - @{{n.message}} (@{{n.author}})
                </li>
                <li v-if="filteredNotes.length === 0" class="list-group-item text-muted text-center italic">
                    No notes match your search.
                </li>
            </ul>
        </div>
    </div>

    <script>
        const { createApp, ref, onMounted, computed } = Vue;

        createApp({
            setup() {
                const notes = ref([]);
                const form = ref({});
                const searchQuery = ref(''); 

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

                const filteredNotes = computed(() => {
                    const query = searchQuery.value.toLowerCase().trim();
                    if (!query) return notes.value;

                    return notes.value.filter(n => {
                        return n.order_number.toString().toLowerCase().includes(query) ||
                               n.message.toLowerCase().includes(query) ||
                               n.author.toLowerCase().includes(query);
                    });
                });

                onMounted(getNotes);

                return { notes, form, save, searchQuery, filteredNotes };
            }
        }).mount('#app');
    </script>
</body>
</html>