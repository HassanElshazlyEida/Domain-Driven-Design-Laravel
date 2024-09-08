<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
export default {
    components: {
        AuthenticatedLayout,
        Head,
        Link,
    },
    props: {
        model: {
            type: Object,
            required: true,
        },
        errors: Object,
    },
    data() {
        return {
            form: {
                id: null,
                first_name: null,
                last_name: null,
                email: null,
                form_id: null,
                tag_ids: [],
            }
        }
    },
    created() {
        if (!this.model.subscriber) {
            return;
        }
        this.form = {
            id: this.model.subscriber.id,
            first_name: this.model.subscriber.first_name,
            last_name: this.model.subscriber.last_name,
            email: this.model.subscriber.email,
            form_id: this.model.subscriber.form.id,
            tag_ids: this.model.subscriber.tags.map(t => t.id),
        };
    },
    methods: {
        submit() {
            if (this.model.subscriber) {
                this.$inertia.put(`/subscribers/${this.model.subscriber.id}`, this.form)
            } else {
                this.$inertia.post('/subscribers', this.form)
            }
        },
    },
}
</script>

<template>
    <Head title="New Subscriber" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Subscriber
            </h2>
        </template>
        <div class="py-12 max-w-7xl">
            <form class="w-full max-w-lg mx-auto" @submit.prevent="submit">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="first_name">
                            First Name
                        </label>
                        <input v-model="form.first_name" class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="first_name" type="text" placeholder="Jane">
                        <div v-if="errors.first_name" class="text-red-600 text-xs">{{ errors.first_name }}</div>

                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="last_name">
                            Last Name
                        </label>
                        <input v-model="form.last_name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="last_name" type="text" placeholder="Doe">
                        <div v-if="errors.last_name" class="text-red-600 text-xs">{{ errors.last_name }}</div>

                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                            E-mail
                        </label>
                        <input v-model="form.email" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="email" type="email">
                        <div v-if="errors.email" class="text-red-600 text-xs">{{ errors.email }}</div>

                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="form_id">
                            Form
                        </label>
                        <div class="relative">
                            <select v-model="form.form_id" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="form_id">
                                <option :value="null">-</option>
                                <option :value="form.id" v-for="form in model.forms" :key="form.id">{{ form.title }}</option>
                            </select>
                        </div>
                        <div v-if="errors.form_id" class="text-red-600 text-xs">{{ errors.form_id }}</div>

                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="tag_ids">
                            Tags
                        </label>
                        <div class="relative">
                            <select v-model="form.tag_ids" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="tag_ids" multiple>
                                <option :value="tag.id" v-for="tag in model.tags" :key="tag.id">{{ tag.title }}</option>
                            </select>
                        </div>
                        <div v-if="errors.tag_ids" class="text-red-600 text-xs">{{ errors.tag_ids }}</div>

                    </div>
                </div>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Save
                </button>
                <Link href="/subscribers" class="text-indigo-600 ml-4">
                    Cancel
                </Link>
            </form>
        </div>
    </AuthenticatedLayout>
</template>