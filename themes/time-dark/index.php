<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>智能班级积分系统</title>
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Microsoft YaHei", sans-serif;
  }

  body {
    width: 100vw;
    height: 100vh;
    overflow: hidden;
    background: linear-gradient(180deg, #0f172a, #1e293b);
    color: #fff;
    position: relative;
  }

  /* 背景图：PC / 手机 自动切换 */
  body::after {
    content: "";
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background-image: url("bg-pc.jpg");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    z-index: -1;
    opacity: 0.25;
  }
  @media (max-width: 768px) {
    body::after {
      background-image: url("bg-mobile.jpg");
    }
  }

  .container {
    display: flex;
    width: 100%;
    height: 100%;
    position: relative;
    z-index: 1;
  }

  .time-section {
    height: 100%;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: width 0.5s ease;
  }

  .container.shrink .time-section {
    width: 50%;
  }

  #time {
    font-size: 120px;
    font-weight: bold;
    margin-bottom: 12px;
  }

  #date {
    font-size: 36px;
    opacity: 0.85;
  }

  .toggle-btn {
    position: absolute;
    top: 30px;
    left: 30px;
    background: rgba(255,255,255,0.1);
    border: none;
    color: #fff;
    padding: 10px 20px;
    border-radius: 10px;
    font-size: 16px;
    cursor: pointer;
    z-index: 10;
  }
  .toggle-btn:hover {
    background: rgba(255,255,255,0.2);
  }

  .score-section {
    height: 100%;
    width: 50%;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }

  .container.shrink .score-section {
    display: flex;
  }

  .score-box {
    width: 420px;
    height: 560px;
    background: rgba(15,23,42,0.85);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 18px;
    backdrop-filter: blur(8px);
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .score-title {
    font-size: 24px;
    text-align: center;
    color: #38bdf8;
    font-weight: bold;
  }

  .tabs {
    display: flex;
    gap: 8px;
  }
  .tab {
    flex: 1;
    padding: 8px;
    text-align: center;
    background: rgba(255,255,255,0.08);
    border-radius: 8px;
    cursor: pointer;
    font-size: 15px;
  }
  .tab.active {
    background: #38bdf8;
    color: #0f172a;
    font-weight: bold;
  }

  .sorts {
    display: flex;
    justify-content: center;
    gap: 10px;
    font-size: 14px;
  }
  .sort {
    padding: 4px 12px;
    background: rgba(255,255,255,0.08);
    border-radius: 6px;
    cursor: pointer;
  }
  .sort.active {
    background: #34d399;
    color: #0f172a;
  }

  .rank-list {
    flex: 1;
    overflow-y: auto;
  }

  /* 头像容器 + 头像框 */
  .avatar-wrap {
    position: relative;
    width: 36px;
    height: 36px;
    margin-right: 10px;
  }
  .avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    background: #333;
  }
  .avatar-frame {
    position: absolute;
    top: -5px;
    left: -5px;
    width: 46px;
    height: 46px;
    pointer-events: none;
    z-index: 2;
  }

  .item {
    display: flex;
    align-items: center;
    padding: 10px 12px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    font-size: 16px;
  }
  .item .no { width: 40px; font-weight: bold; }
  .item .name { flex: 1; }
  .item .score { font-weight: bold; }
  .plus { color: #34d399; }
  .minus { color: #f87171; }

  /* 前三名颜色 */
  .item.rank-1 { color: #ffd700; }
  .item.rank-2 { color: #c0c0c0; }
  .item.rank-3 { color: #cd7f32; }
</style>
</head>

<body>

<div class="container" id="container">
  <button class="toggle-btn" id="toggleBtn">缩小显示</button>

  <div class="time-section">
    <div id="time">00:00:00</div>
    <div id="date">2025-01-01 星期三</div>
  </div>

  <div class="score-section">
    <div class="score-box">
      <div class="score-title" id="scoreTitle">总积分排名</div>
      <div class="tabs">
        <div class="tab active" data-type="total">总积分</div>
        <div class="tab" data-type="add">昨日加分</div>
        <div class="tab" data-type="minus">昨日扣分</div>
      </div>
      <div class="sorts">
        <div class="sort active" data-sort="desc">降序</div>
        <div class="sort" data-sort="asc">升序</div>
      </div>
      <div class="rank-list" id="rankList">加载中...</div>
    </div>
  </div>
</div>

<script>
  // 时间
  function updateTime() {
    const now = new Date();
    const h = String(now.getHours()).padStart(2, '0');
    const m = String(now.getMinutes()).padStart(2, '0');
    const s = String(now.getSeconds()).padStart(2, '0');
    document.getElementById('time').innerText = `${h}:${m}:${s}`;

    const y = now.getFullYear();
    const mon = String(now.getMonth() + 1).padStart(2, '0');
    const d = String(now.getDate()).padStart(2, '0');
    const week = '日一二三四五六'[now.getDay()];
    document.getElementById('date').innerText = `${y}-${mon}-${d} 星期${week}`;
  }
  updateTime();
  setInterval(updateTime, 1000);

  // 切换大小屏
  const container = document.getElementById('container');
  const toggleBtn = document.getElementById('toggleBtn');
  toggleBtn.addEventListener('click', () => {
    container.classList.toggle('shrink');
    toggleBtn.innerText = container.classList.contains('shrink') ? '全屏时间' : '缩小显示';
  });

  // 状态
  let currentType = 'total';
  let currentSort = 'desc';
  let allStudents = [];

  // 从后端接口获取真实数据
  async function fetchData() {
    try {
      const res = await fetch('/admin/api/rank.php');
      const data = await res.json();
      allStudents = data;
      return data;
    } catch (err) {
      console.error(err);
      return [];
    }
  }

  // 榜单处理
  function getList(type) {
    if (type === 'total') {
      return allStudents.map(s => ({
        name: s.name,
        score: s.score,
        avatar: s.avatar || ''
      }));
    }
    if (type === 'add') {
      return allStudents.map(s => ({
        name: s.name,
        score: s.yesterday_add,
        avatar: s.avatar || ''
      }));
    }
    if (type === 'minus') {
      return allStudents.map(s => ({
        name: s.name,
        score: -s.yesterday_minus,
        avatar: s.avatar || ''
      }));
    }
    return [];
  }

  // 渲染
  async function render() {
    if (!allStudents.length) await fetchData();

    let list = getList(currentType);
    list = list.filter(it => it.score !== 0);
    list.sort((a, b) => currentSort === 'desc' ? b.score - a.score : a.score - b.score);

    const titles = {
      total: '总积分排名',
      add: '昨日加分榜',
      minus: '昨日扣分榜'
    };
    document.getElementById('scoreTitle').innerText = titles[currentType];

    document.getElementById('rankList').innerHTML = list.map((it, i) => {
  let cls = '';
  if (it.score > 0) cls = 'plus';
  if (it.score < 0) cls = 'minus';

  // 头像路径逻辑 —— 完全修复
  let avatar = it.avatar || '';
  if (avatar === '' || avatar === null) {
    avatar = '/admin/avatar/default.png';
  } else if (!avatar.startsWith('http') && !avatar.startsWith('/')) {
    avatar = '/admin/avatar/' + avatar;
  }

  // 头像框（前三名）
  let frame = '';
  if (i === 0) frame = '/admin/avatar/1.png';
  if (i === 1) frame = '/admin/avatar/2.png';
  if (i === 2) frame = '/admin/avatar/3.png';

  return `
    <div class="item rank-${i+1}">
      <span class="no">${i+1}</span>
      <div class="avatar-wrap">
        <img src="${avatar}" class="avatar" onerror="this.src='/admin/avatar/default.png'">
        ${frame ? `<img src="${frame}" class="avatar-frame">` : ''}
      </div>
      <span class="name">${it.name}</span>
      <span class="score ${cls}">${it.score}</span>
    </div>
  `;
}).join('') || '<div style="text-align:center;opacity:0.6">暂无数据</div>';
  }

  // 切换
  document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      currentType = tab.dataset.type;
      render();
    });
  });

  document.querySelectorAll('.sort').forEach(s => {
    s.addEventListener('click', () => {
      document.querySelectorAll('.sort').forEach(t => t.classList.remove('active'));
      s.classList.add('active');
      currentSort = s.dataset.sort;
      render();
    });
  });

  render();
</script>
</body>
</html>