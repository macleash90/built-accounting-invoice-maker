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
              placeholder="Enter item name"
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
          <label class="d-flex">Price (GHS):<star></star></label>
          <input
            type="text"
            class="form-control"
            placeholder="Enter item price"
            v-model="form.item_price"
            :disabled="add_or_edit=='view'"
          />
          <errors v-if="form.errors.errors.item_price">
            {{ form.errors.errors.item_price[0] }}
          </errors>
        </div>
        <div class="col-lg-6 form-group">
          <label class="d-flex">Description:</label>
          <div class="">
            <textarea
              class="form-control"
              v-model="form.item_description"
              name="item_description"
              :disabled="add_or_edit=='view'"
            ></textarea>
            <errors v-if="form.errors.errors.item_description">
              {{ form.errors.errors.item_description[0] }}
            </errors>
          </div>
        </div>
        <div class="col-lg-6 form-group" v-if="add_or_edit=='view' || add_or_edit=='edit'">
          <label class="d-flex">Current Image:</label>
          <div class="">
            <img :src="form.item_img" height="150px" />
          </div>
        </div>
        <div class="col-lg-6 form-group" v-if="add_or_edit!='view'">
          <label class="d-flex">Image:</label>
          <div class="">
            <vue-dropzone 
            @vdropzone-success="uploadSuccess"
            @vdropzone-error="uploadError"
            @vdropzone-removed-file="fileRemoved"
            @vdropzone-processing="processingImage"
             ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"
             ></vue-dropzone>
            <errors v-if="form.errors.errors.item_img">
              {{ form.errors.errors.item_img[0] }}
            </errors>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
export default {
  components: { 
  Multiselect: Multiselect,
  vueDropzone: vue2Dropzone
  },
  mounted() {},
  props: ["form", "categories","add_or_edit"],
  data: function () {
    return {
      dropzoneOptions: {
          url: '/items/uploadFile',
          thumbnailWidth: 100,
          maxFilesize: 1.5,
          thumbnailHeight:50,
          maxFiles:1,
          acceptedFiles:"image/*",
          headers: { 
            "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content,
           }
      },
      file_name:"",
    }
  },
  methods: 
  {
    uploadSuccess(file, response) {
        console.log('File Successfully Uploaded with file name: ' + response);
        this.file_name = response.item_img;
        this.$emit('fileUploaded', this.file_name )
    },
    uploadError(file, message) {
        this.$emit('uploadError')
    },
    fileRemoved() {},
    resetImage: function() {
        this.$refs.myVueDropzone.removeAllFiles(true);
    },
    processingImage()
    {
      this.$emit('processingImage');
    }
  }
};
</script>
