<template>
  <div class="login-box">
    <el-row :gutter="10">    
      <el-col :md="12">
        <h2>后台管理系统</h2>
        <p class="login-help">建议使用谷歌、火狐、360极速模式等高级浏览器进行后台操作</p>
        <p class="login-help">账号:developer 密码:123456</p>
      </el-col>
      <el-col :md="12">
        <div class="login-input">
          <el-form ref="form" :model="formData" :rules="formRules">            
            <el-form-item label="Email" prop="email">
              <el-input 
                clearable
                v-model="formData.email"
                placeholder="Email"></el-input>
            </el-form-item>
            <el-form-item label="Password" prop="password">
              <el-input
                clearable                
                v-model="formData.password"
                type="password" 
                placeholder="Password"></el-input>
            </el-form-item>
            <el-form-item class="pt-2">
              <el-button type="primary" rel="login-btn" :loading="loading" @click="onLogin">登录</el-button>
            </el-form-item>
          </el-form>
        </div>
      </el-col>
    </el-row>
  </div>
</template>
<script>
export default {
  data() {
    return {
      formData: {
        email: "",
        password: ""
      },
      formRules: {
        email: [
          { required: true, trigger: "blur", message: "Email is required" }
        ],
        password: [
          { required: true, trigger: "blur", message: "Password is required" }
        ]
      },
      loading: false
    };
  },

  created() {
    this.getAuthInfo();
  },

  methods: {
    getAuthInfo() {
      this.$request.get(
        "/backend/auth/info",
        {},
        () => {
          this.$router.push({ path: "/" });
        },
        err => {
          this.$message.error(err);
        }
      );
    },

    onLogin() {
      if (this.loading) {
        return;
      }

      this.$refs.form.validate(valid => {
        if (!valid) {
          return false;
        }

        this.loading = true;

        this.$request.post(
          "/backend/auth/login",
          this.formData,
          res => {
            this.loading = false;
            if (!res.code) {
              this.$message.error(res.msg);
              return;
            }

            this.$message.success("success");
            this.$auth.setToken(res.data.token);            
            this.$router.push({ path: "/" });            
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
<style lang="scss" scoped>
.login-box {
  max-width: 800px;
  margin: 0 auto;
  padding: 100px 20px 20px;
}

.login-box h2 {
  font-size: 26px;
}

.login-help {
  padding: 10px 0;
}

.login-input {
  background: #ffffff;
  padding: 40px 20px 20px;
  border-radius: 5px;
}
</style>