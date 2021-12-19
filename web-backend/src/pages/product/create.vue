<template>
  <div class="product-container">
    
    <el-breadcrumb separator-class="el-icon-arrow-right" class="mt-2">
        <el-breadcrumb-item :to="{ path: '/dashboard' }">Dashboard</el-breadcrumb-item>
        <el-breadcrumb-item :to="{ path: '/products' }">Products</el-breadcrumb-item>
        <el-breadcrumb-item>Create</el-breadcrumb-item>        
    </el-breadcrumb>

    <el-form :model="formData" :rules="formRules" ref="form">
      <el-row :gutter="20" class="mt-4">
          <el-col :md="16">
              <el-card shadow="hover">
                  <div slot="header" class="clearfix">
                    <span>New Product</span>
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
                  <el-form-item label="Excerpt" prop="excerpt">
                    <el-input 
                      v-model="formData.excerpt"
                      :autosize="{ minRows: 4}"
                      type="textarea"></el-input>
                  </el-form-item>
                  <el-form-item label="Description" prop="description">
                    <el-input 
                      v-model="formData.excerpt"
                      :autosize="{ minRows: 4}"
                      type="textarea"></el-input>
                  </el-form-item>
              </el-card>

              <el-card shadow="hover" class="mt-4">
                  <div slot="header" class="clearfix">
                    <span>Product Media</span>
                  </div>

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
                    :on-success="onImageSuccess">
                    <i class="el-icon-upload"></i>
                    <div class="el-upload__text">Drop file here, or<em> click</em></div>
                    <div 
                      v-loading="uploading"
                      class="product-image">
                      <img v-if="formData.image" :src="formData.showImage">
                      <input v-model="formData.image" type="hidden"/>
                    </div>  
                    <div slot="tip" class="el-upload__tip">This image is visible in all product box.</div>                
                  </el-upload>
                </el-form-item>

                  <el-form-item prop="image">
                    <el-upload
                      action="#"
                      list-type="picture-card"
                      :auto-upload="false">
                        <i slot="default" class="el-icon-plus"></i>
                        <div slot="file" slot-scope="{file}">
                          <img
                            class="el-upload-list__item-thumbnail"
                            :src="file.url" alt="">
                          <span class="el-upload-list__item-actions">
                            <span
                              class="el-upload-list__item-preview"
                              @click="handlePictureCardPreview(file)">
                              <i class="el-icon-zoom-in"></i>
                            </span>                            
                            <span
                              v-if="!disabled"
                              class="el-upload-list__item-delete"
                              @click="handleRemove(file)">
                              <i class="el-icon-delete"></i>
                            </span>
                          </span>
                        </div>
                        <div slot="tip" class="el-upload__tip">These images are visible in product details page gallery. You could drag to reorder images.</div>
                    </el-upload>
                  </el-form-item>   

                  <el-form-item prop="video">
                    <el-input
                      v-model="formData.video"
                      placeholder="https://youtube..."></el-input>
                    <span class="text-xs text-muted">Use proper link without extra parameter. Don't use short share link/embeded iframe code.</span>
                  </el-form-item>

              </el-card>

          </el-col>        
          <el-col :md="8">
              <el-card shadow="hover">
                
              </el-card>
          </el-col>

          <el-col :md="24" class="mt-4">
            <el-button class="fr" type="primary" :loading="loading" @click="onSave">Save</el-button>
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
    onImageSuccess(res) {
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
          "/backend/products/create",
          this.formData,
          res => {
            this.loading = false;
            if (!res.code) {
              this.$message.error(res.msg);
              return;
            }

            this.$message.success("success");            
            this.$router.push({ path: "/products/" + res.data.product_id });
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
    width: 50%;
    @media only screen and (max-width: 767px) {
      width: 100%;
    }
    .product-image {
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

