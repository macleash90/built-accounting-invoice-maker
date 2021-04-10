<template>
  <div class="">
    <div class="card-body">
      <div class="form-group row">
        <div class="col-lg-6 form-group">
          <label class="d-flex">Name:<star></star></label>
          <div class="">
            <input
              type="text"
              name="name"
              class="form-control"
              v-model="form.name"
              autocomplete="off"
              :disabled="add_or_edit=='view'"
            />
            <errors v-if="form.errors.errors.name">
              {{ form.errors.errors.name[0] }}
            </errors>
          </div>
        </div>
        <div class="col-lg-6 form-group">
          <label class="d-flex">Phone Number:</label>
          <input
            type="text"
            class="form-control"
            v-model="form.phone"
            :disabled="add_or_edit=='view'"
          />
          <errors v-if="form.errors.errors.phone">
            {{ form.errors.errors.phone[0] }}
          </errors>
        </div>
        <div class="col-lg-6 form-group">
          <label class="d-flex">Email:</label>
          <input
            type="text"
            class="form-control"
            v-model="form.email"
            :disabled="add_or_edit=='view'"
          />
          <errors v-if="form.errors.errors.email">
            {{ form.errors.errors.email[0] }}
          </errors>
        </div>
        <div class="col-lg-6 form-group">
          <label class="d-flex">Address:</label>
          <div class="">
            <textarea
              class="form-control"
              v-model="form.address"
              name="address"
              :disabled="add_or_edit=='view'"
            ></textarea>
            <errors v-if="form.errors.errors.address">
              {{ form.errors.errors.address[0] }}
            </errors>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  components: { 
  },
  mounted() {},
  props: ["form","add_or_edit"],
  data: function () {
    return {
      
    }
  },
  methods: 
  {
  }
};
</script>
