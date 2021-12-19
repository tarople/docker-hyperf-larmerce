<template>
  <nav class="sidebar">
    <div class="sidebar-header">
        <h1 class="sidebar-brand">Larmerce</h1>
    </div>
    <div class="sidebar-body">
      <el-menu
        :default-active="currentRoute"
        :collapse="collapse"
        unique-opened>
        <div v-for="menu in menus" :index="menu.index" :key="menu.index">

          <template v-if="!menu.subMenus" :index="menu.index">
            <router-link :to="{path: menu.path}" class="menu-link">
              <el-menu-item>
                <i :class="menu.icon"></i>
                <span slot="title">{{menu.name}}</span>
              </el-menu-item>
            </router-link>
          </template>

          <el-submenu v-else :index="menu.index">
            <template slot="title">
              <i :class="menu.icon"></i>
              <span slot="title">{{menu.name}}</span>              
            </template>            
            <router-link 
              v-for="subMenu in menu.subMenus" 
              :key="subMenu.path" 
              :index="subMenu.path" 
              :to="{path: subMenu.path}" class="menu-link">
              <el-menu-item :index="subMenu.path">{{subMenu.name}}</el-menu-item>
            </router-link>
          </el-submenu>

        </div>
      </el-menu>
    </div>
  </nav>
</template>
<script>
export default {
  data () {
    return {
      account: null,
      group: null,
      menus: [
        {
          index: 'Dasboard',
          icon: 'el-icon-pie-chart text-blue',
          name: 'Dashboard',
          subMenus: null,
          path: '/dashboard'
        },
        {
          index: 'product',
          icon: 'el-icon-shopping-bag-1 text-pink',
          name: 'Products',
          subMenus: [
            {
              name: 'Products',
              path: '/products'
            },
            {
              name: 'Collections',
              path: '/collections'
            }
          ]
        },
        {
          index: 'system',
          icon: 'el-icon-setting',
          name: '系统设置',
          subMenus: [
            {
              name: '系统信息',
              path: '/system/index'
            },
            {
              name: '管理员',
              path: '/system/adminUser'
            },
            {
              name: '管理组',
              path: '/system/adminGroup'
            },
            {
              name: '后台接口',
              path: '/system/adminApi'
            }
          ]
        },
      ]
    }
  },  
  props: [
    'collapse'
  ],
  created () {
    // let user = window.localStorage.getItem('user')
    // user = JSON.parse(user)
    // this.account = user.account
    // this.group = user.group
  },
  computed: {
    currentRoute () {
      return this.$route.path
    }
  },
  methods: {

  }
}
</script>
<style lang="scss">

.sidebar {
  transition: width 0.28s;
  width: 250px !important;    
  height: 100%;
  position: fixed;    
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 1001;
  overflow: hidden;
  background-color: #fff;
  box-shadow: 0 0 4px 0 rgb(136, 152, 170, .15);

  .sidebar-header {
    display: flex;
    align-items: center;
    height: 80px;
    padding-left: 24px;
  }

  .sidebar-body {

    .el-menu {
      border: none;
      height: 100%;
      width: 100% !important;
    }

    .el-submenu__title {
      color: rgba(0, 0, 0, 0.6);      
      &:hover {
        background-color: #f6f9fc !important;
      }
    }

    .is-active>.el-submenu__title {
      color: rbga(0, 0, 0, .9) !important;
    }

    .nest-menu .el-submenu>.el-submenu__title,
    .el-submenu .el-menu-item {
      color: rgba(0, 0, 0, 0.6);
      min-width: 250px !important;
      background-color: #fff !important;      
      &:hover {
        background-color: #f6f9fc !important;
      }
    }

    .el-submenu .el-menu-item {
      padding-left: 50px !important;
    }

    .el-menu-item i,
    .el-submenu__title i {
      font-weight: 600;
    }

  }
}

.sidebar-close {
  .sidebar {

    width: 54px !important;

    .sidebar-header {
      padding: 20px 0;
      text-align: center;
    }

    .el-tooltip {
      padding: 0 !important;
      text-align: center;      
    }

    .el-menu--collapse .el-submenu__title {
      padding: 0 !important;
      text-align: center;
    }

    .el-menu--collapse .el-submenu__title span {
        height: 0;
        width: 0;
        overflow: hidden;
        visibility: hidden;
        display: inline-block;
      }

    .el-menu--collapse .el-submenu__title .el-submenu__icon-arrow {
      display: none !important;
    }    
  }
}

// mobile responsive
.mobile.sidebar-close {
  .sidebar {
    pointer-events: none;
    transition-duration: 0.3s;
    transform: translate3d(-250px, 0, 0);
  }
}

</style>
