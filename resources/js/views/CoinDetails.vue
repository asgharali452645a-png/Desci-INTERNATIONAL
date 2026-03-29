<script setup>
import { 
  ArrowLeft, 
  Globe, 
  Twitter, 
  Share2, 
  FileText, 
  FlaskConical, 
  Users, 
  BookOpen, 
  ChevronDown, 
  ChevronRight, 
  MessageCircle,
  Play,
  TrendingUp,
  Info,
  Maximize2,
  ExternalLink,
  Github,
  Youtube,
  ArrowRight
} from 'lucide-vue-next';
import { useRouter } from 'vue-router';
import { ref, onMounted, onUnmounted } from 'vue';
import TopHeader from '../components/TopHeader.vue';

const router = useRouter();
const goBack = () => router.back();

const activeTab = ref('Feed');

// Hero Image Carousel
const heroImages = ref([
    'https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1200&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1200&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1563298723-dcfebaa392e3?q=80&w=1200&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1526336024174-e58f5cdd8e13?q=80&w=1200&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?q=80&w=1200&auto=format&fit=crop'
]);
const currentImageIndex = ref(0);
let autoScrollInterval = null;

const nextImage = () => {
    currentImageIndex.value = (currentImageIndex.value + 1) % heroImages.value.length;
};

const goToImage = (index) => {
    currentImageIndex.value = index;
};

onMounted(() => {
    // Auto-scroll every 5 seconds
    autoScrollInterval = setInterval(() => {
        nextImage();
    }, 5000);
});

onUnmounted(() => {
    if (autoScrollInterval) {
        clearInterval(autoScrollInterval);
    }
});

// Collapsible Sections
const sections = ref([
    { title: 'Research Hypothesis', open: false, content: 'Analysis of the current skincare market and the proposed decentralization of dermatological research nodes.' },
    { title: 'Value Capture Model', open: false, content: 'Explaining the SKIN token utility and how researchers are incentivized to contribute high-quality data.' },
    { title: 'Team', open: false, content: 'Meet the dermatologists and blockchain engineers leading the DermaLabs initiative.' },
    { title: 'Roadmap', open: false, content: 'Q3 2026: Beta testing of AI imaging model. Q4 2026: Launch of decentralized trials.' },
    { title: 'Recommended Reading', open: false, content: 'Access the full whitepaper and clinical feasibility studies for the SKIN protocol.' },
]);

const toggleSection = (index) => {
    sections.value[index].open = !sections.value[index].open;
};

const project = {
    name: "DermaLabs",
    symbol: "SKIN",
    tags: ["IP-NFT", "DAO", "SKINCARE", "WEB3"],
    description: "DermaLabs blends dermatologist-led science with community-powered research. Using decentralized trials, AI imaging, and SKIN token incentives, we turn every skincare journey into measurable evidence.",
    sentiment: "90% Positive",
    communitySize: "666",
    growth: "+0.7%",
    stats: [
        { label: 'Market Cap', value: '$12.4M' },
        { label: 'Volume (24h)', value: '$1.2M' },
        { label: 'Circulating Supply', value: '45.2M SKIN' },
        { label: 'Max Supply', value: '100M SKIN' }
    ],
    feed: [
        { handle: '@DermaDAO', time: 'Today', text: 'Structure defined via @OSISProtocol EIP-20! Proposals live!', stats: '141 💬 230 🔁 55 ❤️', avatar: '/ipnft.png' },
        { handle: '@SkinStandard', time: 'Yesterday', text: 'Analysis on acne and stress signaling gradient LIVE via IP-NFT!', stats: '332 💬 210 🔁 1.5K ❤️', avatar: '/ipnft2.png' }
    ]
};
</script>

<template>
  <div class="coin-details-page">
    <TopHeader />

    <main class="main-wrapper">
      <div class="layout-grid">
        
        <!-- Main Content -->
        <div class="content-area">
            <!-- Hero (Solid) -->
            <section class="hero-box">
                <div class="hero-media">
                    <transition name="fade" mode="out-in">
                        <img :key="currentImageIndex" :src="heroImages[currentImageIndex]" />
                    </transition>
                    <div class="media-overlay">
                        <div class="play-btn">
                            <Play size="32" fill="white" />
                        </div>
                    </div>
                    
                    <!-- Thumbnail Navigation -->
                    <div class="thumbnail-nav">
                        <div 
                            v-for="(image, index) in heroImages" 
                            :key="index"
                            class="thumbnail-item"
                            :class="{ active: currentImageIndex === index }"
                            @click="goToImage(index)"
                        >
                            <img :src="image" :alt="`Thumbnail ${index + 1}`" />
                        </div>
                    </div>
                </div>

                <div class="hero-header">
                    <div class="titles">
                        <div class="logo-box"><FlaskConical size="24" /></div>
                        <div class="names">
                            <h1>{{ project.name }} <span>{{ project.symbol }}</span></h1>
                            <div class="tags">
                                <span v-for="tag in project.tags" :key="tag">{{ tag }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="actions">
                        <button class="icon-btn"><Share2 size="18"/></button>
                        <button class="icon-btn" @click="goBack"><ArrowLeft size="18"/></button>
                    </div>
                </div>
            </section>

            <!-- Metrics -->
            <section class="info-grid">
                <div class="card desc-card">
                    <h3>Overview</h3>
                    <p>{{ project.description }}</p>
                    <div class="socials">
                        <a href="#"><Globe size="18" /></a>
                        <a href="#"><Twitter size="18" /></a>
                        <a href="#"><Github size="18" /></a>
                    </div>
                </div>
                <div class="card market-card">
                    <div class="card-head">
                        <span>Sentiment</span>
                        <span class="badge">{{ project.sentiment }}</span>
                    </div>
                    <div class="sentiment-votes">
                        <div class="vote up">👍 1.2K</div>
                        <div class="vote down">👎 84</div>
                    </div>
                </div>
            </section>

            <!-- Feed -->
            <section class="card feed-card">
                <div class="card-head">
                    <h3>Research Feed</h3>
                    <div class="tabs">
                        <span :class="{active: activeTab === 'Feed'}" @click="activeTab = 'Feed'">Feed</span>
                        <span :class="{active: activeTab === 'Forum'}" @click="activeTab = 'Forum'">Forum</span>
                    </div>
                </div>
                <div class="feed-list">
                    <div v-for="(post, i) in project.feed" :key="i" class="post">
                        <div class="avatar"><img :src="post.avatar" /></div>
                        <div class="p-body">
                            <div class="p-meta">
                                <strong>{{ post.handle }}</strong> • {{ post.time }}
                            </div>
                            <p>{{ post.text }}</p>
                            <div class="p-footer">{{ post.stats }}</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Sidebar -->
        <aside class="sidebar-area">
            <div class="card summary-card gold-border">
                <h3>Project Summary</h3>
                <div class="stats-mini">
                    <div v-for="s in project.stats" :key="s.label" class="mini-s">
                        <span class="l">{{ s.label }}</span>
                        <span class="v">{{ s.value }}</span>
                    </div>
                </div>
                <button class="btn-primary">Contribute <ArrowRight size="16"/></button>
            </div>

            <div class="card knowledge-card">
                <h3>Knowledge Base</h3>
                <div class="faq">
                    <div v-for="(sec, i) in sections" :key="i" class="f-item" @click="toggleSection(i)">
                        <div class="f-head">
                            <span>{{ sec.title }}</span>
                            <ChevronDown size="14" :class="{rotate: sec.open}" />
                        </div>
                        <div v-if="sec.open" class="f-body">{{ sec.content }}</div>
                    </div>
                </div>
            </div>
            
            <div class="card links-list">
                 <h3>Resources</h3>
                 <div class="link-r"><BookOpen size="16"/> Whitepaper <ExternalLink size="12" /></div>
                 <div class="link-r"><FileText size="16"/> Audit <ExternalLink size="12" /></div>
            </div>
        </aside>
      </div>
    </main>

    <footer class="footer">
        <div class="footer-inner">
            <div class="brand">
                <FlaskConical size="20" class="gold" />
                <span>DeSci International</span>
            </div>
            <p>© 2026 Research Node V1</p>
        </div>
    </footer>
  </div>
</template>

<style scoped>
.coin-details-page { background: #000; min-height: 100vh; color: #fff; font-family: 'Inter', sans-serif; }
.main-wrapper { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
.gold { color: #dfff00; }

/* Hero */
.hero-box { background: #111; border: 1px solid #222; border-radius: 20px; overflow: hidden; margin-bottom: 30px; }
.hero-media { height: 300px; position: relative; }
.hero-media img { width: 100%; height: 100%; object-fit: cover; opacity: 0.6; }
.media-overlay { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; }
.play-btn { width: 64px; height: 64px; background: #dfff00; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: transform 0.3s ease; }
.play-btn:hover { transform: scale(1.1); }

/* Fade Transition */
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}

/* Thumbnail Navigation */
.thumbnail-nav {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 12px;
    padding: 12px 20px;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(10px);
    border-radius: 50px;
    z-index: 10;
}

.thumbnail-item {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.3s ease;
    opacity: 0.6;
}

.thumbnail-item:hover {
    opacity: 0.9;
    transform: translateY(-4px);
}

.thumbnail-item.active {
    border-color: #dfff00;
    opacity: 1;
    transform: scale(1.1);
}

.thumbnail-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-header { padding: 24px; display: flex; justify-content: space-between; align-items: center; }
.titles { display: flex; align-items: center; gap: 20px; }
.logo-box { width: 50px; height: 50px; background: #dfff00; color: #000; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.names h1 { font-size: 24px; font-weight: 800; }
.names span { font-size: 14px; color: #666; font-weight: 500; }
.tags { display: flex; gap: 8px; margin-top: 8px; }
.tags span { font-size: 10px; color: #666; border: 1px solid #222; padding: 2px 8px; border-radius: 4px; }
.icon-btn { background: #1a1a1a; border: none; color: #fff; width: 40px; height: 40px; border-radius: 8px; cursor: pointer; }

/* Metrics */
.info-grid { display: grid; grid-template-columns: 1fr 280px; gap: 24px; margin-bottom: 30px; }
.card { background: #111; border: 1px solid #222; border-radius: 20px; padding: 24px; }
.card-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.card h3 { font-size: 16px; font-weight: 700; }
.desc-card p { font-size: 14px; color: #888; line-height: 1.6; margin-bottom: 20px; }
.socials { display: flex; gap: 16px; color: #444; }

.badge { background: #dfff00; color: #000; font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 4px; }
.sentiment-votes { display: flex; gap: 12px; }
.vote { flex: 1; background: #0a0a0a; padding: 12px; border-radius: 12px; text-align: center; font-size: 13px; font-weight: 600; }

/* Tabs & Feed */
.tabs { display: flex; gap: 16px; font-size: 13px; font-weight: 700; color: #444; }
.tabs span { cursor: pointer; }
.tabs span.active { color: #dfff00; }
.post { display: flex; gap: 16px; padding-bottom: 20px; border-bottom: 1px solid #1a1a1a; margin-bottom: 20px; }
.avatar { width: 40px; height: 40px; border-radius: 50%; overflow: hidden; }
.p-meta { font-size: 13px; margin-bottom: 6px; }
.p-body p { font-size: 14px; color: #ccc; line-height: 1.5; margin-bottom: 10px; }
.p-footer { font-size: 12px; color: #444; }

/* Sidebar */
.layout-grid { display: grid; grid-template-columns: 1fr 340px; gap: 30px; }
.sidebar-area { display: flex; flex-direction: column; gap: 24px; }
.gold-border { border-color: rgba(223, 255, 0, 0.2); }
.stats-mini { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
.mini-s { display: flex; flex-direction: column; }
.mini-s .l { font-size: 10px; color: #444; text-transform: uppercase; }
.mini-s .v { font-size: 14px; font-weight: 700; color: #fff; }
.btn-primary { width: 100%; background: #dfff00; color: #000; border: none; padding: 14px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; }

.f-item { border-bottom: 1px solid #1a1a1a; padding: 12px 0; cursor: pointer; }
.f-head { display: flex; justify-content: space-between; align-items: center; font-size: 13px; font-weight: 600; }
.f-body { font-size: 12px; color: #666; margin-top: 10px; line-height: 1.5; }
.rotate { transform: rotate(180deg); }

.link-r { display: flex; align-items: center; gap: 10px; font-size: 13px; color: #666; margin-bottom: 16px; }

/* Footer */
.footer { padding: 40px 20px; border-top: 1px solid #111; margin-top: 60px; }
.footer-inner { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: #444; }

@media (max-width: 1024px) {
    .layout-grid { grid-template-columns: 1fr; }
    .info-grid { grid-template-columns: 1fr; }
}
</style>
