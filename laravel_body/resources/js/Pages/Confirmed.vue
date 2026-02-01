<template>
<app-layout>
    <Head title="Booking Seats -Confirm" />

<section class="confirmed">
	<div class="container">
		<div class="column">
        	<div class="messages-wrapper column">
				<h1>確認画面</h1>
				<p>クルーがご希望の座席へご案内いたしますので、<br />しばらくお待ちください。</p>
			</div>

			<div class="confirmed-wrapper">
				<div class="column">
			
					<div class="submit-button-wrapper t-center">
						<Link
							href="/"
							method="get"
							as="button"
							type="button"
							class="back-button all-set"
						>
							戻 る
						</Link>
					</div>
				</div>
        	</div>
		</div>
    </div>
</section>
        <!-- DEV ONLY: show data passed by SeatController -->
            
        <!-- DEV ONLY: end -->
</app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import { Head, Link } from "@inertiajs/vue3"
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "@/Layouts/Header.vue";
import Footer from "@/Layouts/Footer.vue";

export default defineComponent({
	props: [
		'request'
	],

	components: {
		Head,
		Link,
		AppLayout,
		Header,
		Footer,
	},

	data() {
		return {

		}
	},

	methods: {
		backToIndex() {
			
		}
	}
})
</script>
