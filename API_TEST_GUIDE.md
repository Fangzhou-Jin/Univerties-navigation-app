# API 测试指南 - Admin Home 过滤器功能

本指南说明如何测试 admin/home 页面中的 Universities、Buildings 和 Floors 过滤器功能。

## 功能概述

现在 admin/home 页面的过滤器（universities、buildings、floors）已经连接到后端数据库：

1. **Universities 下拉菜单** - 从数据库中加载所有大学
2. **Buildings 下拉菜单** - 根据选择的大学动态加载建筑
3. **Floors 下拉菜单** - 根据选择的建筑动态加载楼层
4. **房间列表** - 根据选择的大学、建筑和楼层筛选显示

## 添加的 API 路由

### 公开 API 路由（不需要认证）

```php
// 获取所有大学
GET /api/public/universities

// 获取所有建筑
GET /api/public/buildings

// 根据大学ID获取建筑
GET /api/public/buildings/university/{universityId}

// 根据建筑ID获取楼层
GET /api/public/buildings/{buildingId}/floors

// 获取所有房间
GET /api/public/rooms

// 搜索房间（支持多种过滤条件）
GET /api/public/rooms/search?university_id={id}&building_id={id}&floor_number={num}&search_query={query}
```

## 测试步骤

### 1. 准备数据库

确保数据库已经迁移并填充了测试数据：

```bash
php artisan migrate:fresh --seed
```

### 2. 启动应用

```bash
php artisan serve
```

### 3. 测试 API 端点

#### 测试获取大学列表

```bash
curl http://localhost:8000/api/public/universities
```

预期返回：
```json
[
  {
    "id_university_una": 1,
    "university_name_una": "SRH University of Applied Sciences Munich",
    "city_country": "Munich, Germany",
    ...
  },
  ...
]
```

#### 测试获取特定大学的建筑

```bash
curl http://localhost:8000/api/public/buildings/university/2
```

预期返回：
```json
[
  {
    "id_building_una": 1,
    "building_code_una": "A1",
    "building_name_una": "Engineering Building",
    "id_university_una": 2,
    ...
  },
  ...
]
```

#### 测试获取特定建筑的楼层

```bash
curl http://localhost:8000/api/public/buildings/1/floors
```

预期返回：
```json
[
  {
    "floor_number": 2,
    "floor_label": "Floor 2"
  }
]
```

#### 测试搜索房间

```bash
curl "http://localhost:8000/api/public/rooms/search?building_id=1&floor_number=2"
```

预期返回：
```json
[
  {
    "id_room_una": 4,
    "room_number_una": "1.04",
    "room_name_una": "CS Lab",
    "floor_number_una": 2,
    "id_building_una": 1,
    "availability": { "availability_una": "Free" },
    "roomType": { "room_type_una": "Laboratory" },
    ...
  }
]
```

### 4. 测试前端界面

1. 访问：`http://localhost:8000/admins/login`
2. 使用以下凭据登录：
   - 用户名：`admin`
   - 密码：`admin123`
3. 登录后会自动跳转到 `/admins/home`
4. 测试以下功能：
   - **选择大学**：从下拉菜单选择不同的大学，建筑列表应该相应更新
   - **选择建筑**：从建筑下拉菜单选择，楼层列表应该相应更新
   - **选择楼层**：从楼层下拉菜单选择，房间列表应该显示该楼层的所有房间
   - **搜索功能**：在搜索框中输入房间号或房间名称进行搜索
   - **过滤器**：使用侧边栏的过滤器（All、Lecture、Lab、Admin、Service、Free now、Favorites）

## 前端实现要点

### 数据流程

1. **页面加载**：
   - 自动调用 `/api/public/universities` 获取大学列表
   - 自动选择第一个大学并加载其建筑
   - 自动选择第一个建筑并加载其楼层
   - 自动选择第一个楼层并显示房间

2. **用户交互**：
   - 用户选择大学 → 清空建筑和楼层 → 加载该大学的建筑
   - 用户选择建筑 → 清空楼层 → 加载该建筑的楼层
   - 用户选择楼层 → 加载该楼层的房间

3. **房间类型映射**：
   - 数据库中的 `id_room_type_una` (1-5) 映射到前端类型：
     - 1 → lecture (讲座)
     - 2 → lab (实验室)
     - 3 → admin (行政)
     - 4 → service (服务)

4. **可用性映射**：
   - 数据库中的 `id_availability_una`：
     - 1 → Free (可用)
     - 2 → Occupied (占用)

## 注意事项

1. **房间类型映射**：如果数据库中的房间类型ID与前端映射不匹配，请修改 `getRoomType()` 函数中的映射关系。

2. **可访问性信息**：当前建筑的可访问性信息（电梯、楼梯、无障碍洗手间）暂时显示为"信息不可用"，因为数据库表中没有这些字段。如果需要，可以在 `buildings_una` 表中添加这些字段。

3. **性能优化**：如果数据量很大，建议在后端添加分页和缓存机制。

## 故障排除

### 问题：下拉菜单为空

**解决方案**：
1. 检查数据库是否已正确填充数据
2. 检查浏览器控制台是否有错误信息
3. 检查网络请求是否成功返回数据

### 问题：房间不显示

**解决方案**：
1. 确保选择了大学、建筑和楼层
2. 检查数据库中该楼层是否有房间
3. 查看浏览器控制台的网络请求

### 问题：房间类型显示不正确

**解决方案**：
修改 `admins/home.blade.php` 中的 `getRoomType()` 函数，确保类型ID映射正确。

## 文件修改摘要

### 后端文件

1. **app/Http/Controllers/BuildingController.php**
   - 添加 `getFloorsByBuilding()` 方法
   - 导入 `Room` 模型

2. **app/Http/Controllers/RoomController.php**
   - 更新 `search()` 方法，添加楼层和搜索查询支持

3. **routes/web.php**
   - 添加公开API路由组 `/api/public/*`

### 前端文件

1. **resources/views/admins/home.blade.php**
   - 移除硬编码的静态数据
   - 添加 API 调用函数
   - 更新选择器填充逻辑
   - 更新渲染函数以使用动态数据
   - 添加类型和可用性映射函数

## 下一步改进建议

1. **添加加载状态**：在数据加载时显示加载动画
2. **错误处理**：优化API调用失败时的用户提示
3. **缓存机制**：减少重复的API调用
4. **建筑可访问性数据**：扩展数据库表以存储电梯、楼梯等信息
5. **分页支持**：当房间数量很多时添加分页功能

