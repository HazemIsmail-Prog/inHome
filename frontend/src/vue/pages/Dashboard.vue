<script setup lang="ts">
import { computed, inject, onMounted, ref, type Ref } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePreferredDark } from '@vueuse/core'
import {
    ArcElement,
    BarElement,
    CategoryScale,
    Chart as ChartJS,
    Filler,
    Legend,
    LinearScale,
    LineElement,
    PointElement,
    Tooltip,
} from 'chart.js'
import { Bar, Doughnut, Line } from 'vue-chartjs'
import { Activity, HardDrive, RefreshCw, TrendingDown, TrendingUp, Users, Zap } from '@lucide/vue'
import DefaultLayout from '@/vue/layouts/DefaultLayout.vue'
import Button from '@/vue/components/Button.vue'
import { useTabTitle } from '@/ts/composables/tabTitle'
import { windowWidth } from '@/ts/composables/windowSize'
import { buildDashboardMock } from '@/ts/lib/dashboardMock'

ChartJS.register(
    Tooltip,
    Legend,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    BarElement,
    ArcElement,
    Filler,
)

useTabTitle('Dashboard')

const { t } = useI18n()
const mode = inject<Ref<string>>('mode')
const prefersDark = usePreferredDark()

const isDark = computed(
    () =>
        mode?.value === 'dark' ||
        (mode?.value !== 'light' && (mode?.value === 'auto' || mode == null) && prefersDark.value),
)

const tickColors = computed(() =>
    isDark.value
        ? { text: '#c8c8c8', grid: 'rgba(255,255,255,0.07)' }
        : { text: '#525252', grid: 'rgba(0,0,0,0.06)' },
)

const resolvedAccent = ref('rgb(52, 135, 90)')

function rgbaFromRgb(rgb: string, alpha: number): string {
    const m = rgb.match(/\d+(\.\d+)?/g)
    if (!m || m.length < 3) return `rgba(52,135,90,${alpha})`
    return `rgba(${m[0]}, ${m[1]}, ${m[2]}, ${alpha})`
}

function refreshAccent() {
    const p = document.createElement('div')
    p.style.cssText =
        'position:fixed;left:-9999px;top:0;color:var(--accent);pointer-events:none;opacity:0'
    document.body.appendChild(p)
    const c = getComputedStyle(p).color
    document.body.removeChild(p)
    if (c && c !== 'rgba(0, 0, 0, 0)') {
        resolvedAccent.value = c
    }
}

const mock = ref(buildDashboardMock())

function refreshMock() {
    refreshAccent()
    mock.value = buildDashboardMock()
}

onMounted(() => {
    refreshMock()
})

const statIcons = [Users, Activity, Zap, HardDrive]

const trafficLineData = computed(() => ({
    labels: mock.value.weekKeys.map((k) => t(k)),
    datasets: [
        {
            label: t('dashChartSignups'),
            data: mock.value.signupsWeek,
            borderColor: resolvedAccent.value,
            backgroundColor: rgbaFromRgb(resolvedAccent.value, 0.14),
            tension: 0.35,
            fill: true,
            yAxisID: 'y',
        },
        {
            label: t('dashChartRequests'),
            data: mock.value.requestsWeek,
            borderColor: isDark.value ? 'rgba(255,255,255,0.42)' : 'rgba(0,0,0,0.38)',
            backgroundColor: 'transparent',
            tension: 0.3,
            fill: false,
            yAxisID: 'y1',
            borderDash: [6, 4],
        },
    ],
}))

const trafficLineOptions = computed(() => {
    const compact = windowWidth.value < 640
    return {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: compact ? { left: 0, right: 6, top: 4, bottom: 0 } : {},
        },
        interaction: { mode: 'index' as const, intersect: false },
        plugins: {
            legend: {
                position: 'bottom' as const,
                labels: {
                    color: tickColors.value.text,
                    usePointStyle: true,
                    padding: compact ? 10 : 16,
                    boxWidth: compact ? 8 : 12,
                },
            },
        },
        scales: {
            x: {
                ticks: {
                    color: tickColors.value.text,
                    maxRotation: compact ? 45 : 0,
                    autoSkip: true,
                    maxTicksLimit: compact ? 7 : undefined,
                },
                grid: { color: tickColors.value.grid },
            },
            y: {
                type: 'linear' as const,
                position: 'left' as const,
                ticks: {
                    color: tickColors.value.text,
                    maxTicksLimit: compact ? 5 : undefined,
                },
                grid: { color: tickColors.value.grid },
            },
            y1: {
                type: 'linear' as const,
                position: 'right' as const,
                ticks: {
                    color: tickColors.value.text,
                    maxTicksLimit: compact ? 5 : undefined,
                },
                grid: { drawOnChartArea: false },
            },
        },
    }
})

const barData = computed(() => ({
    labels: mock.value.monthKeys.map((k) => t(k)),
    datasets: [
        {
            label: t('dashChartFeatureA'),
            data: mock.value.revenueBars,
            backgroundColor: rgbaFromRgb(resolvedAccent.value, 0.6),
            borderRadius: 8,
        },
        {
            label: t('dashChartFeatureB'),
            data: mock.value.ordersBars,
            backgroundColor: isDark.value ? 'rgba(255,255,255,0.12)' : 'rgba(0,0,0,0.1)',
            borderRadius: 8,
        },
    ],
}))

const barOptions = computed(() => {
    const compact = windowWidth.value < 640
    return {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: compact ? { left: 0, right: 4, top: 4, bottom: 0 } : {},
        },
        plugins: {
            legend: {
                position: 'bottom' as const,
                labels: {
                    color: tickColors.value.text,
                    usePointStyle: true,
                    padding: compact ? 8 : 14,
                    boxWidth: compact ? 8 : 12,
                },
            },
        },
        scales: {
            x: {
                ticks: {
                    color: tickColors.value.text,
                    maxRotation: compact ? 40 : 0,
                    autoSkip: true,
                },
                grid: { display: false },
            },
            y: {
                ticks: {
                    color: tickColors.value.text,
                    maxTicksLimit: compact ? 5 : undefined,
                },
                grid: { color: tickColors.value.grid },
            },
        },
    }
})

const doughnutData = computed(() => ({
    labels: mock.value.roleLabelKeys.map((k) => t(k)),
    datasets: [
        {
            data: mock.value.roleData,
            backgroundColor: [
                resolvedAccent.value,
                rgbaFromRgb(resolvedAccent.value, 0.72),
                rgbaFromRgb(resolvedAccent.value, 0.48),
                isDark.value ? 'rgba(255,255,255,0.2)' : 'rgba(0,0,0,0.16)',
            ],
            borderWidth: 0,
        },
    ],
}))

const doughnutOptions = computed(() => {
    const compact = windowWidth.value < 640
    return {
        responsive: true,
        /** Square parent + true ratio keeps the pie circular (false stretches to the rect). */
        maintainAspectRatio: true,
        layout: {
            padding: compact ? { top: 2, bottom: 4 } : { top: 4, bottom: 6 },
        },
        plugins: {
            legend: {
                position: 'bottom' as const,
                align: 'center' as const,
                labels: {
                    color: tickColors.value.text,
                    usePointStyle: true,
                    padding: compact ? 8 : 12,
                    boxWidth: compact ? 10 : 12,
                    textAlign: 'center' as const,
                },
            },
        },
    }
})
</script>

<template>
    <DefaultLayout>
        <template #header>
            <h1 class="min-w-0 flex-1 break-words text-start leading-snug">
                {{ $t('Dashboard') }}
            </h1>
            <Button
                variant="ghost"
                class="shrink-0"
                :leading-icon="RefreshCw"
                :label="$t('dashRefreshMock')"
                @click="refreshMock"
            />
        </template>

        <div class="flex min-w-0 max-w-full flex-col gap-[var(--space-stack)]">
            <p class="min-w-0 text-sm leading-relaxed text-text-muted">
                {{ $t('dashIntro') }}
            </p>

            <!-- KPI cards -->
            <div
                class="grid min-w-0 grid-cols-1 gap-[var(--space-stack)] sm:grid-cols-2 xl:grid-cols-4"
            >
                <div
                    v-for="(stat, i) in mock.stats"
                    :key="stat.labelKey"
                    class="min-w-0 rounded-xl border border-border bg-background p-[var(--space-page)] shadow-sm"
                >
                    <div class="flex items-start justify-between gap-2">
                        <span
                            class="text-xs font-semibold uppercase tracking-wider text-text-muted"
                        >{{ $t(stat.labelKey) }}</span>
                        <component
                            :is="statIcons[i]"
                            class="size-5 shrink-0 text-accent"
                            :stroke-width="1.75"
                        />
                    </div>
                    <p class="mt-3 text-2xl font-semibold tracking-tight text-text">
                        {{ stat.value }}
                    </p>
                    <div
                        class="mt-2 flex min-w-0 flex-wrap items-center gap-x-1 gap-y-0.5 text-xs font-medium"
                        :class="stat.deltaPositive ? 'text-accent' : 'text-danger'"
                    >
                        <TrendingUp v-if="stat.deltaPositive" class="size-3.5" />
                        <TrendingDown v-else class="size-3.5" />
                        <span>{{ stat.deltaPercent }}</span>
                        <span class="font-normal text-text-muted">{{ $t('dashVsLastWeek') }}</span>
                    </div>
                </div>
            </div>

            <!-- Traffic line chart -->
            <section
                class="min-w-0 max-w-full overflow-hidden rounded-xl border border-border bg-background p-[var(--space-page)] shadow-sm"
            >
                <h2 class="text-xs font-semibold uppercase tracking-wider text-text-muted">
                    {{ $t('dashSectionTraffic') }}
                </h2>
                <p class="mt-1 min-w-0 text-sm text-text-muted">{{ $t('dashSectionTrafficHint') }}</p>
                <div
                    class="relative mt-4 h-56 w-full min-w-0 max-w-full sm:h-64 md:h-72 md:min-h-[16rem]"
                >
                    <Line
                        class="block h-full w-full max-w-full"
                        :data="trafficLineData"
                        :options="trafficLineOptions"
                    />
                </div>
            </section>

            <!-- Bar + doughnut -->
            <div class="grid min-w-0 grid-cols-1 gap-[var(--space-stack)] lg:grid-cols-2">
                <section
                    class="min-w-0 max-w-full overflow-hidden rounded-xl border border-border bg-background p-[var(--space-page)] shadow-sm"
                >
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-text-muted">
                        {{ $t('dashSectionCompare') }}
                    </h2>
                    <p class="mt-1 min-w-0 text-sm text-text-muted">{{ $t('dashSectionCompareHint') }}</p>
                    <div
                        class="relative mt-4 h-56 w-full min-w-0 max-w-full sm:h-64 md:h-72 md:min-h-[16rem]"
                    >
                        <Bar
                            class="block h-full w-full max-w-full"
                            :data="barData"
                            :options="barOptions"
                        />
                    </div>
                </section>

                <section
                    class="min-w-0 max-w-full overflow-hidden rounded-xl border border-border bg-background p-[var(--space-page)] shadow-sm"
                >
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-text-muted">
                        {{ $t('dashSectionRoles') }}
                    </h2>
                    <p class="mt-1 min-w-0 text-sm text-text-muted">{{ $t('dashSectionRolesHint') }}</p>
                    <div class="mt-4 flex w-full justify-center">
                        <div
                            class="relative aspect-square w-full max-w-[min(100%,17.5rem)] sm:max-w-xs md:max-w-sm"
                        >
                            <Doughnut
                                class="absolute inset-0 block h-full w-full max-w-full"
                                :data="doughnutData"
                                :options="doughnutOptions"
                            />
                        </div>
                    </div>
                </section>
            </div>

            <!-- Recent activity -->
            <section
                class="min-w-0 max-w-full overflow-hidden rounded-xl border border-border bg-background shadow-sm"
            >
                <div class="min-w-0 border-b border-border px-[var(--space-page)] py-3">
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-text-muted">
                        {{ $t('dashSectionActivity') }}
                    </h2>
                    <p class="mt-1 text-sm text-text-muted">{{ $t('dashSectionActivityHint') }}</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[18rem] text-start text-sm">
                        <thead class="bg-secondary-background">
                            <tr>
                                <th
                                    class="px-[var(--space-page)] text-start py-3 text-xs font-semibold uppercase tracking-wider text-accent"
                                >
                                    {{ $t('dashColUser') }}
                                </th>
                                <th
                                    class="px-[var(--space-page)] text-start py-3 text-xs font-semibold uppercase tracking-wider text-accent"
                                >
                                    {{ $t('dashColAction') }}
                                </th>
                                <th
                                    class="px-[var(--space-page)] text-start py-3 text-xs font-semibold uppercase tracking-wider text-accent"
                                >
                                    {{ $t('dashColTime') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(row, idx) in mock.activity"
                                :key="idx"
                                class="border-b border-border text-text-muted transition-colors hover:bg-hover"
                            >
                                <td
                                    class="max-w-[9rem] px-[var(--space-page)] py-2.5 font-medium text-text break-words sm:max-w-none"
                                >
                                    {{ $t(row.userKey) }}
                                </td>
                                <td
                                    class="max-w-[10rem] px-[var(--space-page)] py-2.5 break-words sm:max-w-none"
                                >
                                    {{ $t(row.actionKey) }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-[var(--space-page)] py-2.5 text-text-muted"
                                >
                                    {{ $t(row.timeKey) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </DefaultLayout>
</template>
