<template>
<app-layout>
    <Head title="Booking Seats -Confirm" />

<section class="confirm">
	<div class="container">
		<div class="column">
          <div class="messages-wrapper column">
			<h1>確認画面</h1>
			<p v-if="isSeatAvailable">{{ form.prioritizedOrderForGuidance[0]['inJP'] }}に空席がございますので、<br />
			よろしければ確定をタップしてください。</p>
			<p v-else>恐れ入りますが、<br />ご指定の座席で空席がございません。</p>
		  </div>

		  <form @submit.prevent="confirmed" class="confirm-form column">
			<div v-if="form.prioritizedOrderForGuidance.length > 0" class="show-input-number">
					<p>
						{{ form.guestsCountInput }}名様
					</p>
					<p>
						{{ form.prioritizedOrderForGuidance[0]['inJP'] }}
					</p>
            </div>
			<div v-else class="show-input-number">
				<p>空席数：0</p>
			</div>

			<div class="submit-button-wrapper t-center">

				<div
					v-on:click="backToIndex"
					class="back-button all-set"
				>
					修 正
				</div>
				<button
					:type="submit"
					class="submit-button all-set"
					id="submitButton"
					v-bind:disabled="!isSeatAvailable"
				>
					確 定
				</button>

			<!-- Debug 
				<button type="button" v-on:click="showValue">showValue</button>
			-->
			</div>
          </form>
		</div>
    </div>
</section>
        <!-- DEV ONLY: show data passed by SeatController -->
            
        <!-- DEV ONLY: end -->
</app-layout>
</template>

<script>
import { defineComponent } from "vue";
import { Inertia } from "@inertiajs/vue3"
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "../Layouts/Header.vue";
import Footer from "../Layouts/Footer.vue";

export default defineComponent({
  props: [
	  "request",
	  "prioritizedOrderForGuidance"
	],

  components: {
    Head,
    AppLayout,
    Header,
    Footer,
  },

  data() {
    return {

		// values below are only for developement
		form: this.$inertia.form({
        	guestsCountInput: this.request.guestsCountInput,
			selectedSeatTypes: this.request.selectedSeatTypes, // it is not rendered but pass data through
        	prioritizedOrderForGuidance: this.prioritizedOrderForGuidance,
        }),

		isSeatAvailable: false,
    };
  },

  created() {
	  if (this.prioritizedOrderForGuidance <= 0) {
		  this.isSeatAvailable = false
	  } else {
		  this.isSeatAvailable = true
	  }
  },

  methods: {

	showValue() {
		console.log(this.form.prioritizedOrderForGuidance)
	},
	  
	confirmed() {
		console.log("confirmed")
		this.form.patch(route("confirmed"))
	},

	backToIndex() {
		console.log("send post")
		this.form.post(route("show"))
  	},
  }
})
</script>