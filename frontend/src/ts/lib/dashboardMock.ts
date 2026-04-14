export interface DashboardStatMock {
    labelKey: string
    value: string
    deltaPercent: string
    deltaPositive: boolean
}

export interface ActivityRowMock {
    userKey: string
    actionKey: string
    timeKey: string
}

function rnd(min: number, max: number): number {
    return Math.floor(Math.random() * (max - min + 1)) + min
}

function rndFloat(min: number, max: number, decimals: number): string {
    const n = Math.random() * (max - min) + min
    return n.toFixed(decimals)
}

/** Fresh random dashboard payload (call on mount / refresh). */
export function buildDashboardMock() {
    const totalUsers = rnd(820, 3200)
    const activeSessions = rnd(40, 220)
    const api24h = rnd(12000, 89000)
    const storageGb = rndFloat(2.1, 48.7, 1)

    const stats: DashboardStatMock[] = [
        {
            labelKey: 'dashStatUsers',
            value: totalUsers.toLocaleString(),
            deltaPercent: `${rnd(2, 24)}%`,
            deltaPositive: Math.random() > 0.25,
        },
        {
            labelKey: 'dashStatSessions',
            value: activeSessions.toLocaleString(),
            deltaPercent: `${rnd(3, 31)}%`,
            deltaPositive: Math.random() > 0.3,
        },
        {
            labelKey: 'dashStatApi',
            value: api24h.toLocaleString(),
            deltaPercent: `${rnd(5, 42)}%`,
            deltaPositive: Math.random() > 0.2,
        },
        {
            labelKey: 'dashStatStorage',
            value: `${storageGb} GB`,
            deltaPercent: `${rnd(1, 12)}%`,
            deltaPositive: Math.random() > 0.4,
        },
    ]

    const weekKeys = [
        'dashWeekMon',
        'dashWeekTue',
        'dashWeekWed',
        'dashWeekThu',
        'dashWeekFri',
        'dashWeekSat',
        'dashWeekSun',
    ]
    const signupsWeek = weekKeys.map(() => rnd(8, 95))
    const requestsWeek = weekKeys.map(() => rnd(1200, 9800))

    const monthKeys = [
        'dashMonJan',
        'dashMonFeb',
        'dashMonMar',
        'dashMonApr',
        'dashMonMay',
        'dashMonJun',
    ]
    const revenueBars = monthKeys.map(() => rnd(12, 55))
    const ordersBars = monthKeys.map(() => rnd(8, 42))

    const roleSlices = {
        admin: rnd(5, 18),
        manager: rnd(12, 28),
        staff: rnd(25, 45),
        viewer: rnd(15, 35),
    }
    const activityUsers = [
        'dashActUser1',
        'dashActUser2',
        'dashActUser3',
        'dashActUser4',
        'dashActUser5',
    ]
    const activityActions = [
        'dashActLogin',
        'dashActEditUser',
        'dashActExport',
        'dashActPerm',
        'dashActPwd',
        'dashActApi',
    ]
    const activityTimes = [
        'dashActTime1',
        'dashActTime2',
        'dashActTime3',
        'dashActTime4',
        'dashActTime5',
    ]

    const activity: ActivityRowMock[] = Array.from({ length: 6 }, (_, i) => ({
        userKey: activityUsers[rnd(0, activityUsers.length - 1)]!,
        actionKey: activityActions[rnd(0, activityActions.length - 1)]!,
        timeKey: activityTimes[Math.min(i, activityTimes.length - 1)]!,
    }))

    const roleLabelKeys = [
        'dashRoleAdmin',
        'dashRoleManager',
        'dashRoleStaff',
        'dashRoleViewer',
    ] as const
    const roleData = [
        roleSlices.admin,
        roleSlices.manager,
        roleSlices.staff,
        roleSlices.viewer,
    ]

    return {
        stats,
        weekKeys,
        signupsWeek,
        requestsWeek,
        monthKeys,
        revenueBars,
        ordersBars,
        roleLabelKeys,
        roleData,
        activity,
    }
}
