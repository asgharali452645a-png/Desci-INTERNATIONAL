<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import {
    Menu,
    X,
    User,
    LayoutDashboard,
    LogOut,
    ChevronRight,
    FlaskConical,
    Dna,
    Stethoscope,
    Microscope,
    Database,
    BarChart3,
    Globe,
    Wallet,
    ArrowLeftRight,
    ArrowUpRight,
    TrendingUp,
    ShieldCheck,
    FileText,
    Users,
    Compass,
    Trophy,
    Gift,
    Link2,
    Clock,
    History,
    Repeat,
    Rocket,
    Zap,
    LayoutGrid,
    BarChart2,
} from 'lucide-vue-next'
import TransactionModals from './TransactionModals.vue'

const router = useRouter()
const userData = ref(null)

const loadUserData = () => {
    const stored = localStorage.getItem('user')
    if (stored) {
        try {
            userData.value = JSON.parse(stored)
        } catch (e) {
            console.error('Data corruption detected in TopHeader, resetting', e)
            localStorage.removeItem('user')
            userData.value = null
        }
    }
}

const handleLogout = async () => {
    try {
        await window.axios.post('/logout')
    } catch (e) {
        console.error('Logout error', e)
    }
    localStorage.removeItem('user')
    userData.value = null
    window.location.href = '/'
}


const isMobile = ref(window.innerWidth < 1100)
const handleResize = () => {
    isMobile.value = window.innerWidth < 1100
}

onMounted(() => {
    loadUserData()
    window.addEventListener('user-logged-in', loadUserData)
    window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
    window.removeEventListener('user-logged-in', loadUserData)
    window.removeEventListener('resize', handleResize)
})

const isMenuOpen = ref(false)
const isUserMenuOpen = ref(false)
const isWalletMenuOpen = ref(false)
const showDepositModal = ref(false)
const showWithdrawModal = ref(false)


const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value
    if (isMenuOpen.value) {
        isUserMenuOpen.value = false
        isWalletMenuOpen.value = false
    }
}

const toggleUserMenu = () => {
    isUserMenuOpen.value = !isUserMenuOpen.value
    if (isUserMenuOpen.value) {
        isMenuOpen.value = false
        isWalletMenuOpen.value = false
    }
}

const toggleWalletMenu = () => {
    isWalletMenuOpen.value = !isWalletMenuOpen.value
    if (isWalletMenuOpen.value) {
        isMenuOpen.value = false
        isUserMenuOpen.value = false
    }
}

const navigate = (path) => {
    isMenuOpen.value = false
    isUserMenuOpen.value = false
    isWalletMenuOpen.value = false
    
    if (path === '/logout') {
        handleLogout()
        return
    }

    if (path === '/deposit') {
        showDepositModal.value = true
        return
    }

    router.push(path)
}

const menuSections = [
    {
        title: 'Home',
        items: [
            { name: 'Home', icon: Globe, path: '/' },
        ],
    },
    {
        title: 'Swap',
        items: [
            { name: 'Swap', icon: ArrowLeftRight, path: '/token-swap' },
        ],
    },
    {
        title: 'Market',
        items: [
            { name: 'Market', icon: TrendingUp, path: '/market' },
            { name: 'Coin Details', icon: BarChart3, path: '/asset/1' },
        ],
    },
    {
        title: 'Launchpad',
        items: [
            { name: 'Projects', icon: Rocket, path: '/launchpad' },
            { name: 'Bridge', icon: Link2, path: '/bridge' },
            { name: 'Neuro Trade', icon: FlaskConical, path: '/spot-grid-bots' },
            { name: 'Arbitrage Bot', icon: BarChart3, path: '/arbitrage-bot' },
            { name: 'AI Agents', icon: Users, path: '/copy-trading' },
            { name: 'Trading Bots', icon: BarChart2, path: '/trading-bots', mobileOnly: true },
            { name: 'Bot Analytics', icon: BarChart3, path: '/arbitrage-bot-chart', mobileOnly: true },
            { name: 'Create Algo', icon: Zap, path: '/spot-grid-create', mobileOnly: true },
        ],
    },
    {
        title: 'IP-NFTs',
        items: [
            { name: 'IP-NFTs', icon: Dna, path: '/nft' },
            { name: 'Collection Details', icon: LayoutGrid, path: '/collection-details' },
        ],
    },
    {
        title: 'Discover',
        items: [
            { name: 'Leaderboard', icon: Trophy, path: '/leaderboard' },
            { name: 'Contest', icon: TrendingUp, path: '/contest' },
            { name: 'Referral Program', icon: Gift, path: '/referral' },
            { name: 'MLM Program', icon: Users, path: '/mlm' },
            { name: 'Funding History', icon: History, path: '/funding-rate-history' },
            { name: 'My Portfolios', icon: Wallet, path: '/portfolios', mobileOnly: true },
            { name: 'My Copy Portfolio', icon: Wallet, path: '/my-copy-portfolio', mobileOnly: true },
            { name: 'Copy Settings', icon: ShieldCheck, path: '/spot-copy-settings', mobileOnly: true },
            { name: 'Trader Settings', icon: User, path: '/copy-trading-settings', mobileOnly: true },
        ],
    },
    {
        title: 'Institutional Repository',
        items: [
            { name: 'News', icon: FileText, path: '/announcements' },
            { name: 'Announcement Center', icon: Compass, path: '/announcements' },
            { name: 'Campaign', icon: Zap, path: '/contest' },
            { name: 'Proof Of Reserves', icon: ShieldCheck, path: '/proof-of-reserves' },
            { name: 'Governance Documents', icon: FileText, path: '/governance' },
            { name: 'Ecosystem', icon: Microscope, path: '/ecosystem' },
        ],
    },


]

const userModules = [
    { name: 'Dashboard', icon: LayoutDashboard, path: '/dashboard' },
    { name: 'Portfolio', icon: Wallet, path: '/portfolio' },
    { name: 'Identification', icon: ShieldCheck, path: '/identification' },
    { name: 'Logout', icon: LogOut, path: '/logout' },
]

const walletModules = [
    { name: 'Deposit', icon: ArrowLeftRight, path: '/deposit' },
    { name: 'Withdraw', icon: ArrowUpRight, path: '/dashboard/withdrawls' },
    { name: 'Asset History', icon: History, path: '/asset-history' },
    { name: 'Convert History', icon: Repeat, path: '/convert-history' },
    { name: 'Transaction History', icon: Clock, path: '/transaction-history' },
    { name: 'Order History', icon: FileText, path: '/order-history', mobileOnly: true },
]
</script>

<template>
    <header class="top-header">
        <div class="header-content">
            <!-- Left: Brand -->
            <div class="brand" @click="navigate('/')">
                <img src="/logo.png" alt="Logo" class="logo-img" />
                <span class="brand-name">Desci <span class="accent">INTERNATIONAL</span></span>
            </div>


            <!-- Center: Desktop Nav -->
            <nav class="desktop-nav">
                <div class="nav-links">
                    <template v-for="section in menuSections" :key="section.title">
                        <!-- Direct Link (Single Item) -->
                        <div
                            v-if="['Home', 'Swap', 'Market', 'IP-NFTs'].includes(section.title)"
                            class="nav-link"
                            @click="navigate(section.items[0].path)"
                        >
                            {{ section.items[0].name }}
                        </div>

                        <!-- Dropdown Group (Multiple Items) -->
                        <div v-else class="nav-item-group">
                            <span class="group-title">
                                {{ section.title }}
                                <ChevronRight size="14" class="group-arrow" />
                            </span>
                            <div class="dropdown-menu">
                                <div 
                                    v-for="item in section.items.filter(i => !i.mobileOnly)" 
                                    :key="item.name" 
                                    class="dropdown-item"
                                    @click="navigate(item.path)"
                                >
                                    <component :is="item.icon" size="16" class="dd-icon" />
                                    <span>{{ item.name }}</span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </nav>

            <!-- Right: Actions -->
            <div class="header-actions">
                <button class="action-btn user-btn" @click="toggleUserMenu">
                    <User size="20" />
                </button>

                <button class="action-btn wallet-btn" @click="toggleWalletMenu">
                    <Wallet size="20" />
                </button>

                <button class="action-btn menu-btn" @click="toggleMenu">
                    <Menu v-if="!isMenuOpen" size="24" />
                    <X v-else size="24" />
                </button>
            </div>
        </div>

        <!-- Full Screen Navigation Menu -->
        <transition name="menu-fade">
            <div v-if="isMenuOpen" class="main-menu-overlay">
                <div class="menu-scroll-container">
                    <div class="menu-grid">
                        <div
                            v-for="section in menuSections"
                            :key="section.title"
                            class="menu-section"
                        >
                            <h3 class="section-title">{{ section.title }}</h3>
                            <div class="section-items">
                                <div
                                    v-for="item in section.items"
                                    :key="item.name"
                                    class="menu-item"
                                    @click="navigate(item.path)"
                                >
                                    <div class="item-icon-box">
                                        <component :is="item.icon" size="20" />
                                    </div>
                                    <div class="item-info">
                                        <span class="item-name">{{ item.name }}</span>
                                        <ChevronRight size="14" class="arrow-icon" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="menu-footer">
                        <p>© 2026 OSIS INTERNATIONAL. Empowering Scientific Innovation.</p>
                    </div>
                </div>
            </div>
        </transition>

        <!-- User Profile Dropdown/Menu -->
        <transition name="menu-slide">
            <div v-if="isUserMenuOpen" class="user-menu-overlay">
                <div class="user-menu-content">
                    <div class="user-info-card">
                        <div class="avatar-large">
                            <User size="32" />
                        </div>
                        <div class="user-details">
                            <span class="user-id">{{ userData ? userData.name : 'Guest User' }}</span>
                            <span class="user-email">{{ userData ? userData.email : 'Please log in' }}</span>
                        </div>
                    </div>

                    <div class="user-links">
                        <div class="menu-sub-title">User</div>
                        <div
                            v-for="item in userModules.filter(i => isMobile || !i.mobileOnly)"
                            :key="item.name"
                            class="user-link-item"
                            @click="navigate(item.path)"
                        >
                            <component :is="item.icon" size="18" />
                            <span>{{ item.name }}</span>
                        </div>


                    </div>
                </div>
                <div class="close-overlay" @click="isUserMenuOpen = false"></div>
            </div>
        </transition>

        <!-- Wallet Menu Dropdown -->
        <transition name="menu-slide">
            <div v-if="isWalletMenuOpen" class="user-menu-overlay">
                <div class="user-menu-content">
                    <div class="user-info-card">
                        <div class="avatar-large">
                            <Wallet size="32" />
                        </div>
                        <div class="user-details">
                            <span class="user-id">Wallet</span>
                            <span class="user-email">Manage your assets</span>
                        </div>
                    </div>

                    <div class="user-links">
                        <div class="menu-sub-title">Wallet Options</div>
                        <div
                            v-for="item in walletModules.filter(i => isMobile || !i.mobileOnly)"
                            :key="item.name"
                            class="user-link-item"
                            @click="navigate(item.path)"
                        >
                            <component :is="item.icon" size="18" />
                            <span>{{ item.name }}</span>
                        </div>
                    </div>
                </div>
                <div class="close-overlay" @click="isWalletMenuOpen = false"></div>
            </div>
        </transition>

        <TransactionModals 
            :showDeposit="showDepositModal"
            :showWithdraw="showWithdrawModal"
            @close-deposit="showDepositModal = false"
            @close-withdraw="showWithdrawModal = false"
        />
    </header>
</template>

<style scoped>
.top-header {
    position: sticky;
    top: 0;
    left: 0;
    left: 0;
    width: 100%;
    max-width: 100%;
    height: 70px;
    background: rgba(0, 0, 0, 0.85);
    backdrop-filter: blur(15px);
    border-bottom: 1px solid #1a1a1a;
    z-index: 1500;
    font-family: 'IBM Plex Sans', sans-serif;
}

.header-content {
    max-width: 1400px;
    margin: 0 auto;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 24px;
}

/* Brand */
.brand {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
}

.logo-img {
    width: 32px;
    height: 32px;
    object-fit: cover;
    border-radius: 50%;
}

.brand-name {
    font-weight: 800;
    font-size: 18px;
    letter-spacing: 2px;
    color: white;
    white-space: nowrap;
}

.brand-name .accent {
    color: var(--primary);
}

/* Desktop Nav */
.desktop-nav {
    display: none;
}

@media (min-width: 1100px) {
    .desktop-nav {
        display: block;
    }
    
    .header-actions .menu-btn {
        display: none;
    }
}

.nav-links {
    display: flex;
    gap: 15px;
    align-items: center;
}

.nav-link {
    font-size: 14px;
    font-weight: 600;
    color: #fff;
    cursor: pointer;
    transition: color 0.3s;
    white-space: nowrap;
}

.nav-link:hover {
    color: white;
}

/* Dropdown Groups */
.nav-item-group {
    position: relative;
    cursor: pointer;
    padding: 8px 0;
}

.group-title {
    font-size: 14px;
    font-weight: 600;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: color 0.3s;
}

.nav-item-group:hover .group-title {
    color: white;
}

.group-arrow {
    transform: rotate(90deg);
    transition: transform 0.3s;
}

.nav-item-group:hover .group-arrow {
    transform: rotate(-90deg);
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(10px);
    background: #1e2329;
    min-width: 220px;
    border-radius: 8px;
    padding: 8px;
    opacity: 0;
    visibility: hidden;
    transition: all 0.2s ease-in-out;
    box-shadow: 0 8px 24px rgba(0,0,0,0.4);
}

.nav-item-group:hover .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(0);
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: #fff;
    font-size: 14px;
    border-radius: 4px;
    transition: background 0.2s, color 0.2s;
}

.dropdown-item:hover {
    background: #2b3139;
    color: white;
}

.dd-icon {
    color: #fff;
}
.dropdown-item:hover .dd-icon {
    color: var(--primary);
}

/* Actions */
.header-actions {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-shrink: 0;
}

.action-btn {
    background: transparent;
    border: none;
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.3s;
}

.action-btn:hover {
    background: rgba(255, 255, 255, 0.05);
    color: var(--primary);
}

/* Hamburger Menu */
.hamburger-lines {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 18px;
    height: 14px;
}

.hamburger-lines span {
    display: block;
    height: 2px;
    width: 100%;
    background: #fff;
    border-radius: 2px;
}

/* Main Menu Overlay */
.main-menu-overlay {
    position: fixed;
    top: 70px;
    left: 0;
    width: 100%;
    height: calc(100vh - 70px);
    background: #000;
    z-index: 1400;
    overflow-y: auto;
}

.menu-scroll-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
}

.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
}

.section-title {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--primary);
    margin-bottom: 24px;
    opacity: 0.8;
}

.section-items {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.menu-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 12px;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s;
}

.menu-item:hover {
    background: #111;
}

.item-icon-box {
    width: 40px;
    height: 40px;
    background: #1a1a1a;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    transition: all 0.3s;
}

.menu-item:hover .item-icon-box {
    background: var(--primary);
    color: #000;
}

.item-info {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.item-name {
    font-size: 16px;
    font-weight: 500;
    color: white;
}

.arrow-icon {
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s;
}

.menu-item:hover .arrow-icon {
    opacity: 1;
    transform: translateX(0);
}

.menu-footer {
    margin-top: 80px;
    padding-top: 40px;
    border-top: 1px solid #1a1a1a;
    text-align: center;
    color: #fff;
    font-size: 12px;
}

/* User Menu */
.user-menu-overlay {
    position: fixed;
    top: 70px;
    right: 0;
    width: 320px;
    height: calc(100vh - 70px);
    z-index: 1600;
    display: flex;
}

.user-menu-content {
    width: 100%;
    background: #0d0d0d;
    border-left: 1px solid #1a1a1a;
    display: flex;
    flex-direction: column;
    position: relative;
    z-index: 2;
}

.close-overlay {
    position: fixed;
    top: 70px;
    left: 0;
    width: calc(100% - 320px);
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
}

.user-info-card {
    padding: 32px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    border-bottom: 1px solid #1a1a1a;
}

.avatar-large {
    width: 56px;
    height: 56px;
    background: var(--primary);
    color: #000;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.user-details {
    display: flex;
    flex-direction: column;
}

.user-id {
    font-weight: 700;
    font-size: 16px;
}

.user-email {
    font-size: 12px;
    color: #fff;
}

.user-links {
    flex: 1;
    padding: 24px 0;
}

.user-link-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 24px;
    color: #fff;
    cursor: pointer;
    transition: all 0.3s;
}

.user-link-item:hover {
    background: #111;
    color: white;
}

.user-link-item:hover span {
    color: var(--primary);
}

.user-footer-actions {
    padding: 24px;
    border-top: 1px solid #1a1a1a;
}

.logout-btn {
    width: 100%;
    padding: 14px;
    background: #1a1a1a;
    border: none;
    border-radius: 12px;
    color: #ff3b30;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
}

.logout-btn:hover {
    background: #251010;
}

.menu-sub-title {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #444;
    padding: 0 24px 8px;
}

.mt-4 {
    margin-top: 16px;
}

/* Animations */
.menu-fade-enter-active,
.menu-fade-leave-active {
    transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.menu-fade-enter-from,
.menu-fade-leave-to {
    opacity: 0;
}

.menu-slide-enter-active,
.menu-slide-leave-active {
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.menu-slide-enter-from,
.menu-slide-leave-to {
    transform: translateX(100%);
}

/* Mobile Responsive Styles */
@media (max-width: 480px) {
    .logo-img {
        width: 28px;
        height: 28px;
    }

    .brand-name {
        font-size: 12px;
        letter-spacing: 0.5px;
    }

    .action-btn {
        width: 36px;
        height: 36px;
    }

    .search-overlay {
        left: 12px;
        right: 60px;
    }

    .search-input-group {
        height: 40px;
        padding: 0 12px;
    }

    .header-search-input {
        font-size: 13px;
    }

    .menu-content {
        padding: 20px;
    }

    .menu-section-title {
        font-size: 11px;
        padding: 12px 0 8px;
    }

    .menu-item {
        padding: 14px 16px;
        font-size: 14px;
    }

    .user-menu {
        width: 90%;
        max-width: 320px;
    }
}

@media (max-width: 768px) {
    .desktop-only {
        display: none;
    }

    .brand-name {
        font-size: 14px;
        letter-spacing: 1px;
    }

    .desktop-nav {
        display: none;
    }

    .header-content {
        padding: 0 16px;
    }

    .search-overlay {
        left: 16px;
        right: 70px;
    }
}

/* Search Overlay Styles */
.search-overlay {
    position: absolute;
    top: 50%;
    left: 20px;
    right: 80px;
    transform: translateY(-50%);
    z-index: 10;
}

.search-input-group {
    display: flex;
    align-items: center;
    background: #111;
    border: 1px solid #333;
    border-radius: 12px;
    padding: 0 16px;
    height: 44px;
    gap: 12px;
}

.search-bar-icon {
    color: #666;
}

.header-search-input {
    flex: 1;
    background: transparent;
    border: none;
    color: white;
    font-size: 14px;
    outline: none;
}

.close-search-btn {
    background: transparent;
    border: none;
    color: #666;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.3s;
}

.close-search-btn:hover {
    color: white;
}

/* Transitions */
.search-slide-enter-active,
.search-slide-leave-active {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.search-slide-enter-from,
.search-slide-leave-to {
    opacity: 0;
    transform: translateY(-50%) scale(0.95);
}
</style>
