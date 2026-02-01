<template>
    <!-- Page Heading -->
    <Header></Header>

    <!-- Page Content -->
    <slot></slot>

            <!-- Page Footer -->
    <Footer></Footer>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/vue3';
    import Header from './Header.vue'
    import Footer from './Footer.vue'

    export default defineComponent({
        props: {
            title: String,
        },

        components: {
            Head,
            Link,
            Header,
            Footer,
        },

        data() {
            return {
                
            }
        },

        methods: {
            
        }
    })
</script>
