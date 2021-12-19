<template>
    <div :class="'page-wrapper ' + sidebarToogle + ' ' + mobile ">
        <div v-if="mobile==='mobile' && sidebarToogle == 'sidebar-open'" 
          class="drawer-bg" 
          @click="handleClickMask" />
        <sidebar :collapse="sidebarCollapse"/>
        <main class="main-content">
            <navbar/>
            <div class="content-container">
              <router-view></router-view>
            </div>
        </main>
    </div>
</template>
<script>
import Sidebar from "./sidebar"
import Navbar from "./navbar"

const { body } = document

export default {
  data () {
    return {
      sidebarToogle: 'sidebar-open',
      sidebarCollapse: false,
      mobile: '',
    }
  },
  created () {
    this.$bus.$on('toogle-sidebar', () => {
        if (this.sidebarToogle == 'sidebar-open') {
          this.sidebarToogle = 'sidebar-close'
          this.sidebarCollapse = true
        } else {
          this.sidebarToogle = 'sidebar-open'
          this.sidebarCollapse = false
        }
    })
  },
  components: {
    'sidebar': Sidebar,
    'navbar': Navbar
  },
  watch: {
    // 监听路由变化
    // $route (to, from) {
        
    // }
  },

  beforeMount() {
    window.addEventListener('resize', this.resizeHandler)
  },

  beforeDestroy() {
    window.removeEventListener('resize', this.resizeHandler)
  },

  mounted() {    
    if (this.isMobile()) {
      this.mobile = 'mobile'
    }
  },

  methods: {

    isMobile() {
      const rect = body.getBoundingClientRect()
      return rect.width - 1 < 767
    },

    resizeHandler() {
      if (this.isMobile()) {
        this.mobile = 'mobile'
        this.sidebarToogle = 'sidebar-close'
        this.sidebarCollapse = true
      } else {
        this.mobile = ''
        this.sidebarToogle = 'sidebar-open'
        this.sidebarCollapse = false
      }
    },
    
    handleClickMask() {      
      this.sidebarToogle = 'sidebar-close'
      this.sidebarCollapse = true
    }
  }
}
</script>
<style lang="scss">

.drawer-bg {
  background: #000;
  opacity: 0.3;
  width: 100%;
  top: 0;
  height: 100%;
  position: absolute;
  z-index: 999;
}

.sidebar-close .main-content {
  margin-left: 56px;
}

.mobile.sidebar-close .main-content {
  margin-left: 0px;
}

</style>

