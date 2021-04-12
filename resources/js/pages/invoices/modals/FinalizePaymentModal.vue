<template>
  <div
    class="modal fade"
    id="confirmSaleModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h2 class="modal-title" id="confirmSaleModalTitle">Finalize Sale</h2>
          <h5>Amount Due (GHS):<span class="red_color">{{form.amount_to_pay}}</span></h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <i aria-hidden="true" class="ki ki-close"></i>
          </button>
        </div>
        <form @submit.prevent="$emit('finalize-sale-submit')">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6 mt-1 form-group" >
                    <label class="d-flex"
                      >Cash Paid(GHS): <star></star
                    ></label>
                    <input
                      v-model="form.cash_payment"
                      type="text"
                      name="cash_payment"
                      class="form-control numkey"
                      :disabled="form.selected_payment_option != 'Cash' && form.selected_payment_option != 'Cash and Momo'"
                    />
                    <errors v-if="form.errors.errors.cash_payment">
                      {{ form.errors.errors.cash_payment[0] }}
                    </errors>
                  </div>
                  <div class="col-md-6 mt-1 form-group">
                    <label class="d-flex"
                      >Momo Paid (GHS): <star></star
                    ></label>
                    <input
                      v-model="form.momo_payment"
                      type="text"
                      name="momo_payment"
                      class="form-control numkey"
                      :disabled="form.selected_payment_option != 'Momo' && form.selected_payment_option != 'Cash and Momo'"
                    />
                    <errors v-if="form.errors.errors.momo_payment">
                      {{ form.errors.errors.momo_payment[0] }}
                    </errors>
                  </div>
                  <div class="col-md-6 mt-1 form-group">
                    <label class="d-flex"
                      >Grand Total (GHS): <star></star
                    ></label>
                    <input
                      v-model="form.amount_to_pay"
                      type="text"
                      name="paid_amount"
                      class="form-control numkey"
                      disabled
                    />
                    <errors v-if="form.errors.errors.grandTotal">
                      {{ form.errors.errors.grandTotal[0] }}
                    </errors>
                  </div>
                  <div class="col-md-6 mt-1 form-group">
                    <label class="d-flex">Change (GHS): </label>
                    <input
                      v-model="changeAmount"
                      id="change"
                      type="text"
                      name="paid_amount"
                      class="form-control numkey"
                      value="0.00"
                      disabled
                    />
                    <errors v-if="form.errors.errors.change">
                      {{ form.errors.errors.change[0] }}
                    </errors>
                  </div>
                  <div class="col-md-6 mt-1 form-group">
                    <label class="d-flex">Payment Mode <star></star></label>
                    <multiselect
                      v-model="form.selected_payment_option"
                      :options="payment_options"
                      name="selected_payment_option"
                      placeholder="Search or select"
                      @select="clearPaymentAmount"
                      disabled
                    ></multiselect>
                    <errors v-if="form.errors.errors.selected_payment_option">
                      {{ form.errors.errors.selected_payment_option[0] }}
                    </errors>
                  </div>
                  <div class="form-group col-md-6 cheque">
                    <label class="d-flex"
                      >Momo Number
                      <star
                        v-if="form.selected_payment_option == 'Momo' || form.selected_payment_option == 'Cash and Momo'"
                      ></star>
                    </label>
                    <input
                      type="number"
                      :disabled="form.selected_payment_option != 'Momo' && form.selected_payment_option != 'Cash and Momo'"
                      name="momo_number"
                      v-model="form.momo_number"
                      class="form-control"
                    />
                    <errors v-if="form.errors.errors.momo_number">
                      {{ form.errors.errors.momo_number[0] }}
                    </errors>
                  </div>
                  <div class="col-md-6 mt-1 form-group">
                    <label class="d-flex">Sale Date: </label>
                    <input
                      v-model="form.sale_date"
                      id="sale_date"
                      type="date"
                      name="sale_date"
                      class="form-control"
                    />
                    <errors v-if="form.errors.errors.sale_date">
                      {{ form.errors.errors.sale_date[0] }}
                    </errors>
                  </div>
                  <div class="col-md-6 form-group">
                    <label>Sale Note</label>
                    <textarea
                      v-model="form.sale_note"
                      rows="3"
                      class="form-control"
                      name="sale_note"
                    ></textarea>
                    <errors v-if="form.errors.errors.sale_note">
                      {{ form.errors.errors.sale_note[0] }}
                    </errors>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-light-primary font-weight-bold"
              data-dismiss="modal"
            >
              Close
            </button>
            <button
              :disabled="finalize_modal_saving"
              type="submit"
              class="btn btn-primary font-weight-bold"
            >
              Proceed
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import Multiselect from "vue-multiselect";
export default {
  props: ["payment_options", "form", "changeAmount", "finalize_modal_saving"],
  components: { Multiselect },
  methods: {
    clearPaymentAmount()
    {
      this.$emit("clear-payment-amount");
    }
  },
};
</script>