<template>
  <div class="navbar">

    <div class="navbar-toggler" @click="toggleSideBar">
      <i class="el-icon-s-fold"></i>
    </div>  

    <div class="navbar-nav">
      <el-dropdown class="notification-container nav-item" trigger="click">
        <div class="notification-wrapper">          
          <i class="el-icon-bell"></i>
        </div>
        <el-dropdown-menu slot="dropdown">          
          <router-link to="/profile/index">
            <el-dropdown-item>
              <span>青春是一个短暂的美梦, 当你醒来时, 它早已消失无踪</span>
            </el-dropdown-item>
          </router-link>
          <router-link to="/">
            <el-dropdown-item>
              <span>青春是一个短暂的美梦, 当你醒来时, 它早已消失无踪</span>
            </el-dropdown-item>
          </router-link>          
        </el-dropdown-menu>
      </el-dropdown>

      <el-dropdown class="user-container nav-item">
        <div class="user-wrapper">
          <img src="@/assets/avatar.jpeg" class="user-avatar">
          <span class="user-name">{{admin.name}}</span>
        </div>
        <el-dropdown-menu slot="dropdown">
          <router-link to="/profile/index">
            <el-dropdown-item>Profile</el-dropdown-item>
          </router-link>
          <router-link to="/">
            <el-dropdown-item>Dashboard</el-dropdown-item>
          </router-link>
          <el-dropdown-item @click.native="logout">Log Out</el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      admin: {}
    };
  },
  created() {
    this.getAuthInfo();
  },

  methods: {
    toggleSideBar() {
      this.$bus.$emit("toogle-sidebar");
    },

    getAuthInfo() {
      this.$request.get(
        "/backend/auth/info",
        {},
        res => {
          this.admin = res.data;
        },
        err => {
          this.$message.error(err);
        }
      );
    },

    logout() {
      this.$request.get(
        "/backend/auth/logout",
        {},
        res => {
          if (!res.code) {
            this.$message.error(res.msg);
            return;
          }

          this.$auth.removeToken();
          this.$router.push({ path: "/login" });
        },
        err => {
          this.$message.error(err);
        }
      );
    }
  }
};
</script>

<style lang="scss" scoped>
.navbar {
  display: flex;
  height: 80px;
  overflow: hidden;
  position: relative;
  align-items: center;
  padding: 15px;
  background: #f7fafc;
  border-bottom: 1px solid #e9ecef !important;

  .navbar-toggler {
    cursor: pointer;
    color: #525f7f;
    font-weight: 600;
    font-size: 18px;
  }

  .navbar-nav {
    display: flex;
    align-items: center;
    margin-left: auto;
    &:focus {
      outline: none;
    }

    .nav-item {
      display: inline-block;
      padding: 0 8px;
      height: 100%;
      font-size: 18px;
      color: #525f7f;
      cursor: pointer;
      i {
        font-weight: 600;
      }
    }

    .user-container {
      .user-wrapper {
        display: flex;
        align-items: center;
        .user-avatar {
          cursor: pointer;
          width: 40px;
          height: 40px;
          border-radius: 50%;
        }
        .user-name {
          font-size: 14px;
          font-weight: 600;
          margin-left: 6px;
        }
      }
    }
  }
}
</style>
