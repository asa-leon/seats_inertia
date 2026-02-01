<template>
  <app-layout>
    <Head title="Booking Seats -Welcome" />

    <section class="home">
      <div class="container">
        <div class="column">
          <div class="messages-wrapper column">
            <h1>当店へようこそ</h1>
            <p id="openingMessage">
              空席を確認いたしますので、お客さまの人数と<br />
              ご希望の席の種類をご選択ください。
            </p>
          </div>

          <form @submit.prevent="confirm" class="input-form">
            <div class="column">
              <div class="num-and-select-buttons row">
                <div class="number-input-wrapper">
                  <div class="column">
                    <p v-if="!checkInputNum" class="input-part-message">
                      1から50の整数で入力してください。
                    </p>
                    <p v-else class="input-part-message">
                      お客様の人数をご入力ください。
                    </p>

                    <div class="z-stack">
                      <input
                        type="text"
                        v-model="form.guestsCountInput"
                        v-bind:class="[
                          'number-input',
                          't-center',
                          !checkInputNum ? 'invalidNum' : 'validNum',
                        ]"
                        autocomplete="off"
                        required
                      />

                      <!-- NumberPad start -->
                      <div
                        v-bind:class="[
                          'number-pad-wrapper',
                          maskOver ? 'mask' : '',
                        ]"
                      >
                        <table
                          v-bind:class="['number-pad', maskOver ? 'mask' : '']"
                        >
                          <tr>
                            <td>
                              <input
                                type="button"
                                v-on:click="detectInputs($event)"
                                value="7"
                                v-bind:disabled="maskOver"
                              />
                            </td>
                            <td>
                              <input
                                type="button"
                                v-on:click="detectInputs($event)"
                                value="8"
                                v-bind:disabled="maskOver"
                              />
                            </td>
                            <td>
                              <input
                                type="button"
                                v-on:click="detectInputs($event)"
                                value="9"
                                v-bind:disabled="maskOver"
                              />
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input
                                type="button"
                                v-on:click="detectInputs($event)"
                                value="4"
                                v-bind:disabled="maskOver"
                              />
                            </td>
                            <td>
                              <input
                                type="button"
                                v-on:click="detectInputs($event)"
                                value="5"
                                v-bind:disabled="maskOver"
                              />
                            </td>
                            <td>
                              <input
                                type="button"
                                v-on:click="detectInputs($event)"
                                value="6"
                                v-bind:disabled="maskOver"
                              />
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input
                                type="button"
                                v-on:click="detectInputs($event)"
                                value="1"
                                v-bind:disabled="maskOver"
                              />
                            </td>
                            <td>
                              <input
                                type="button"
                                v-on:click="detectInputs($event)"
                                value="2"
                                v-bind:disabled="maskOver"
                              />
                            </td>
                            <td>
                              <input
                                type="button"
                                v-on:click="detectInputs($event)"
                                value="3"
                                v-bind:disabled="maskOver"
                              />
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input
                                type="button"
                                class="not-number"
                                v-on:click="detectInputs($event)"
                                name="delete"
                                value="消去"
                                v-bind:disabled="!isDeletable || maskOver"
                              />
                            </td>
                            <td>
                              <input
                                type="button"
                                v-on:click="detectInputs($event)"
                                value="0"
                                v-bind:disabled="maskOver"
                              />
                            </td>

                            <td>
                              <input
                                type="button"
                                class="not-number"
                                v-on:click="detectInputs($event)"
                                name="return"
                                value="決定"
                                v-bind:disabled="!inputDone || maskOver"
                              />
                            </td>
                          </tr>
                        </table>
                        <span
                          v-bind:class="[
                            'type-numbers-message',
                            maskOver ? 'mask' : '',
                          ]"
                        >
                          <p v-on:click="maskToggle">
                            入力する場合は<br />こちらをタップ
                          </p>
                        </span>
                      </div>
                      <!-- NumberPad end -->
                    </div>
                  </div>
                </div>

                <span class="number-input-suffix">名様</span>

                <div class="seat-select-buttons-wrapper">
                  <div class="column">
                    <p v-if="!checkInputNum" class="input-part-message">
                      1から50の整数で入力してください。
                    </p>
                    <p v-else class="input-part-message">
                      ご希望の席種をご選択ください。
                    </p>

                    <div class="seat-select-buttons column">
                      <input
                        type="button"
                        v-for="seatType in seatTypes"
                        :key="seatType.id"
                        v-bind:value="seatType.inJP"
                        v-on:click="sstBasket($event, seatType)"
                        class="seat-select-button neumorphism"
                        ref="seatTypeButton"
                      />
                    </div>
                  </div>
                </div>
              </div>

              <div class="submit-button-wrapper t-center">
                <button
                  :type="button"
                  :class="['submit-button', { 'all-set': checkAllSet }]"
                  id="submitButton"
                >
                  確 認
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Header from "@/Layouts/Header.vue";
import Footer from "@/Layouts/Footer.vue";

export default defineComponent({
  props: ["request"],

  components: {
    Head,
    AppLayout,
    Header,
    Footer,
  },

  data() {
    return {
      seatTypes: [
        { id: "counter", inJP: "カウンター" },
        { id: "tableSeat", inJP: "テーブル席" },
        { id: "tatamiRoom", inJP: "座敷席" },
      ],
	  inputDone: false,
	  isDeletable: false,
	  maskOver: false,
      checkInputNum: true,
      checkAllSet: false,

      form: this.$inertia.form({
        guestsCountInput: "",
        selectedSeatTypes: [],
      }),
    };
  },

  created() {
    () => {},
      this.$watch(
        () => [
          this.$data.form.guestsCountInput,
          this.$data.form.selectedSeatTypes,
		  this.$data.checkInputNum
        ],

        ([val1, val2, val3]) => {
          // val1: InputNum's validation
        	if ((val1 > 0 && val1 <= 50) || val1 == "") {
				//console.log(val1, val2);
				this.checkInputNum = true;

				// val2: selectedSetTypes' validattion
				if (val2.length >= 1 && val2.length <= 3) {
					if (val1 != "") {
						this.checkAllSet = true;
					} else {
						this.checkAllSet = false;
					}
				} else {
					this.checkAllSet = false;
				}
        	} else {
				// When input number is valid and any of seatType is selected,
				// make confirm button active.

				//console.log(val1, val2);
				this.checkInputNum = false;
				this.checkAllSet = false;
        	}

			// toggle boolean of return button
			if (val1 != '' && val3 != false) {
				this.inputDone = true
			} else {
				this.inputDone = false
			}

			// toggle boolean of delete button
			if (val1.length >= 1) {
				this.isDeletable = true
			} else {
				this.isDeletable = false
			}
        },
        {
          deep: true,
        }
      );
  },

  mounted() {
    // 'Confirm'で修正をタップされた場合の、'Index'上のデータ等の調整を行う
    if (this.request != null) {
      (this.form.guestsCountInput = this.request.guestsCountInput),
        (this.form.selectedSeatTypes = this.request.selectedSeatTypes);

      // 'Confirm'から渡された'selectedSeatTypes'に応じて、css用の'selected'を付与する
      for (let $i = 0; $i < this.$refs.seatTypeButton.length; $i++) {
        const stb = this.$refs.seatTypeButton[$i];
        for (let $j = 0; $j < this.form.selectedSeatTypes.length; $j++) {
          const sst = this.form.selectedSeatTypes[$j];
          if (stb.value == sst.inJP) {
            stb.classList.add("selected");
          }
        }
      }
    }
  },

  methods: {

	detectInputs(event) {

		switch (event.target.name) {
			case 'delete':
				this.form.guestsCountInput = this.form.guestsCountInput.slice(0, -1)
				console.log(this.form.guestsCountInput.length)
				break;

			case 'return':
				if (this.inputDone) {
					console.log('input is done')
					this.maskOver = true
				}
				break;
		
			default:
				this.form.guestsCountInput = this.form.guestsCountInput + event.target.value
				break;
		}
		
		console.log(this.form.guestsCountInput)
	},

		maskToggle() {
			if (this.maskOver) {
				this.maskOver = false
			} else {
				this.maskOver = true
		}
	},

    sstBasket(event, seatType) {
      console.log(seatType);

      const result = this.form.selectedSeatTypes.some(
        (item) => item.id === seatType.id
      );

      if (result) {
        console.log("It has!");
        let idx = this.form.selectedSeatTypes.findIndex(
          (sst) => sst.id == seatType.id
        );
        this.form.selectedSeatTypes.splice(idx, 1);
        event.target.classList.remove("selected");
      } else {
        console.log("It does not have!");
        this.form.selectedSeatTypes.push(seatType);
        event.target.classList.add("selected");
      }

      /*
		if (this.form.selectedSeatTypes.some(seatType)) {
			console.log(this.form.selectedSeatTypes.some(seatType))
			
			//let idx = this.form.selectedSeatTypes.findIndex(seatType.id)
			//this.form.selectedSeatTypes.splice(idx, 1)
			event.target.classList.remove('selected')
		} else {
			this.form.selectedSeatTypes.push(seatType)
			event.target.classList.add('selected')
		}
*/
      console.log(this.form.selectedSeatTypes);
    },

    confirm() {
      if (this.checkAllSet) {
        console.log("send post");
        this.form.post(route("confirm"));
      }
    },
  },
});
</script>
