<template>
  <div class="collection-container">
    
    <el-breadcrumb separator-class="el-icon-arrow-right" class="mt-2">
        <el-breadcrumb-item :to="{ path: '/dashboard' }">Dashboard</el-breadcrumb-item>
        <el-breadcrumb-item :to="{ path: '/collections' }">Collections</el-breadcrumb-item>
        <el-breadcrumb-item>Create</el-breadcrumb-item>        
    </el-breadcrumb>

    <el-form :model="formData" :rules="formRules" ref="form">
      <el-row :gutter="20" class="mt-4">
          <el-col :md="16">
              <el-card shadow="hover">
                  <div slot="header" class="clearfix">
                    <span>Create Collection</span>                    
                  </div>
                  <el-form-item label="Title" prop="title">
                    <el-input v-model="formData.title"></el-input>
                  </el-form-item>
                  <el-form-item label="Slug" prop="slug">
                    <el-input
                      v-model="formData.slug"
                      placeholder="xx-xx-xx"></el-input>
                    <span class="text-xs text-muted">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</span>
                  </el-form-item>
                  <el-form-item label="Description" prop="description">
                    <el-input 
                      v-model="formData.description"
                      :autosize="{ minRows: 4}"
                      type="textarea"></el-input>
                  </el-form-item>
              </el-card>
          </el-col>        
          <el-col :md="8">
              <el-card shadow="hover">
                <el-form-item prop="image">
                  <el-upload                                    
                    class="upload-container"
                    drag
                    name="image"
                    :multiple="false"
                    :show-file-list="false"
                    :headers="headers"
                    :action="uploadUrl"                  
                    :on-progress="onProgress"
                    :on-success="handleImageSuccess">
                    <i class="el-icon-upload"></i>
                    <div class="el-upload__text">Drop file here, or<em> click</em></div>
                    <div 
                      v-loading="uploading"
                      class="collection-image">
                      <img v-if="formData.image" :src="formData.showImage">
                      <input v-model="formData.image" type="hidden"/>
                    </div>                  
                  </el-upload>
                </el-form-item>
              </el-card>
          </el-col>

          <el-col :md="24" class="mt-4">
            <el-button class="fr" type="primary" :loading="loading" @click="save">Save</el-button>
          </el-col>

      </el-row>   
    </el-form>   
            
  </div>
</template>
<script>
import config from "@/config";

export default {
  data() {
    return {
      uploadUrl: config.apiHost + "/backend/upload/image",
      headers: {
        Authorization: "Bearer " + this.$auth.getToken()
      },
      uploading: false,
      formData: {
        title: "",
        slug: "",
        description: "",
        image: "",
        showImage: ""
      },
      formRules: {
        title: [
          { required: true, trigger: "blur", message: "Title is required" }
        ],
        slug: [
          { required: true, trigger: "blur", message: "Slug is required" }
        ],
        image: [
          { required: true, message: "Image is required" }
        ],
        description: [
          {
            required: true,
            trigger: "blur",
            message: "Description is required"
          }
        ]
      },
      loading: false
    };
  },

  created() {},

  methods: {
    onProgress() {
      this.uploading = true;
    },
    handleImageSuccess(res) {
      this.uploading = false;
      this.formData.image = res.data.save_image;
      this.formData.showImage = res.data.show_image;
    },
    save() {
      if (this.loading) {
        return;
      }

      this.$refs.form.validate(valid => {
        if (!valid) {
          return false;
        }

        this.loading = true;

        this.$request.post(
          "/backend/collections/create",
          this.formData,
          res => {
            this.loading = false;
            if (!res.code) {
              this.$message.error(res.msg);
              return;
            }

            this.$message.success("success");            
            this.$router.push({ path: "/collections/" + res.data.collection_id });
          },
          err => {
            this.loading = false;
            this.$message.error(err);
          }
        );

      });
    }
  }
};
</script>
<style lang="scss" scope>
.upload-container {
  .el-upload {
    width: 100% !important;
  }
  .el-upload-dragger {
    position: relative;
    width: 100% !important;
    .collection-image {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      text-align: center;
      img {
        display: inline-block;
        width: auto;
        height: auto;
        max-width: 100%;
        max-height: 100%;
        vertical-align: middle;
      }
    }
  }
}
</style>

