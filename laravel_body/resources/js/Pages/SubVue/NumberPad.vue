<template>
	
	<div 
		v-bind:class="[
			'number-pad-wrapper',
			maskOver ? 'mask' : ''
		]"
	>
		<table 
			v-bind:class="[
				'number-pad',
				maskOver ? 'mask' : ''
			]"
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
						v-bind:disabled="
							!isDeletable || maskOver
						"
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
						v-bind:disabled="
							!inputDone || maskOver
						"
					/>
				</td>
			</tr>
		</table>
		<span 
			v-bind:class="[
				'type-numbers-message',
				maskOver ? 'mask' : ''
			]"
		>
			<p v-on:click="maskToggle">入力する場合は<br />こちらをタップ</p>
		</span>
	</div>
	
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: {
			// binded variables in Index.vue
			'checkInputNum': {
				type: Boolean,
				default: 'false'
			},
			'numbersInputFromParent': {
				default: ''
			},
			'inputDoneByParent': {
				type: Boolean,
				default: false,
			},
			'isDeletableByParent': {
				type: Boolean,
				default: false,
			},
        },

        data() {
            return {

				numbersInput: this.numbersInputFromParent,
				inputDone: this.inputDoneByParent,
				isDeletable: this.isDeletableByParent,
				maskOver: false,
				
            }
        },

		created() {
			() => {
				this.numbersInput = this.numbersInputFromParent
			},
			this.$watch(
				() => [
					this.$data.numbersInput,
					this.checkInputNum,
					this.$data.numbersInput,
				],
				([val1, val2, val3]) => {

					// toggle boolean of return button
					if (val1 != '' && val2 != false) {
						this.inputDone = true
					} else {
						this.inputDone = false
					}

					// toggle boolean of delete button
					if (val3.length >= 1) {
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

        methods: {
            detectInputs(event) {

				switch (event.target.name) {
					case 'delete':
						this.numbersInput = this.numbersInput.slice(0, -1)
						console.log(this.numbersInput.length)
						break;

					case 'return':
						if (this.inputDone) {
							console.log('input is done')
							this.maskOver = true
						}
						break;
				
					default:
						this.numbersInput = this.numbersInput + event.target.value
						break;
				}
				
				console.log(this.numbersInput)
				this.$emit('passNumbers', this.numbersInput)
			},

			maskToggle() {
				if (this.maskOver) {
					this.maskOver = false
				} else {
					this.maskOver = true
				}
			},
        }
    })
</script>