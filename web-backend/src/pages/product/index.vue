<template>
  <div class="product-container">
    
    <el-breadcrumb separator-class="el-icon-arrow-right" class="mt-2">
        <el-breadcrumb-item :to="{ path: '/dashboard' }">Dashboard</el-breadcrumb-item>
        <el-breadcrumb-item>Products</el-breadcrumb-item>        
    </el-breadcrumb>

    <el-card class="mt-4" shadow="hover">
        <el-row :gutter="20">
            <el-col :md="6">
                <el-input v-model="search.title" placeholder="Title" clearable/>
            </el-col>        
            <el-col :md="6">
                <el-button type="info" @click="onSearch">Search</el-button>
                <el-button @click="onReset">Reset</el-button>            
            </el-col>            
        </el-row>
    </el-card>  

    <el-card class="mt-4" shadow="hover">
        <router-link :to="{ path: '/products/create' }">
            <el-button type="info" icon="el-icon-plus" plain>New Product</el-button>
        </router-link>
        <el-table
            class="mt-4"
            :data="list"            
            v-loading="loading"
            style="width: 100%">
            <el-table-column
                fixed="left"
                prop="image"
                align="center"
                width="100"
                label="Img">
                <template slot-scope="{row}">  
                    <el-image
                    style="width: 60px; height: 60px"
                    :src="row.image"
                    fit="fit"></el-image>
                </template>
            </el-table-column>
            <el-table-column
                prop="product_id"
                width="40"
                align="center"
                label="ID">
            </el-table-column>            
            <el-table-column
                prop="title"
                label="Title">
            </el-table-column>
            <el-table-column
                prop="price"
                label="Price">
            </el-table-column>
            <el-table-column
                prop="quantity"
                label="Quantity">
            </el-table-column>           
            <el-table-column label="Status" width="100">
                <template slot-scope="{row}">                    
                    <el-tag v-if="row.status === 1" type="success" size="small">
                    active
                    </el-tag> 
                    <el-tag v-else size="small">
                    disabled
                    </el-tag>
                </template>
            </el-table-column>
            <el-table-column
                prop="created_at"
                label="Date">
            </el-table-column>            
            <el-table-column
                fixed="right"
                label="Action"
                align="center"
                width="120">
                <template slot-scope="{row}">
                    <el-dropdown size="small" split-button type="info" plain>
                        <router-link :to="{ path: '/products/edit/' + row.product_id }">Edit</router-link>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item icon="el-icon-view" class="text-blue">View</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-view" class="text-blue">Preview</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-check" class="text-green">Active</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-close" class="text-yellow">Disabled</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-delete" :divided="true" class="text-red">Delete</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>                    
                </template>
            </el-table-column>
        </el-table>

        <div class="block mt-4">    
            <pagination v-show="total>0" 
                :total="total" 
                :page.sync="search.page" 
                :limit.sync="search.limit" 
                @pagination="getList"/>
        </div>    

    </el-card>
        
  </div>
</template>
<script>
import Pagination from "@/components/pagination";

export default {
  components: { Pagination },
  data() {
    return {
      search: {},
      list: [],
      total: 0,
      loading: false
    };
  },

  created() {
    this.getList();
  },

  methods: {
    // get products
    getList() {
      this.loading = true;
      this.$request.get(
        "/backend/products",
        this.search,
        res => {
          this.loading = false;
          this.list = res.data.data;
          this.total = res.data.total;
        },
        err => {
          this.loading = false;
          this.$message.error(err);
        }
      );
    },

    // search
    onSearch() {
      this.getList();
    },

    // reset search
    onReset() {
      this.searchForm = {
        title: ""
      };
      this.getList();
    },

    // delete
    onDelete(id) {
      this.$confirm("Are your sure?", { type: "warning", center: true }).then(
        () => {
          this.$request.get(
            "/backend/products/delete/" + id,
            {},
            res => {
              if (!res.code) {
                this.$message.error(res.msg);
                return;
              }

              this.$message.success(res.msg);
              this.list = this.list.filter(f => {
                return f.product_id !== id;
              });
            },
            err => {
              this.$message.error(err);
            }
          );
        }
      );
    }
  }
};
</script>
