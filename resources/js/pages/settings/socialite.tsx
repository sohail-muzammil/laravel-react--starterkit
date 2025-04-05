import { Head, Link, usePage } from '@inertiajs/react';
import React from 'react';

import HeadingSmall from '@/components/heading-small';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';

interface Props {
    socialAccounts?: number[];
}

const SocialiteSettings: React.FC<Props> = ({ socialAccounts }) => {
    const page = usePage();
    const providers = page.props.oauth_providers || [];

    const breadcrumbs = [
        {
            title: 'Social Accounts settings',
            href: '/settings/socialite',
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Social Accounts settings" />

            <SettingsLayout>
                <div className="space-y-6">
                    <HeadingSmall title="Social Accounts information" description="Connect or disconnect your social accounts" />

                    <div className="overflow-x-auto">
                        <Table>
                            <TableCaption>A list of your recent invoices.</TableCaption>
                            <TableHeader>
                                <TableRow>
                                    <TableHead className="w-[100px]">Provider</TableHead>
                                    <TableHead className="text-right">Action</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {providers.map((provider: any, index: number) => (
                                    <TableRow key={index}>
                                        <TableCell className="flex items-center gap-2 font-medium capitalize">
                                            <span dangerouslySetInnerHTML={{ __html: provider.icon }} className="mr-2"></span>
                                            <span>{provider.name}</span>
                                        </TableCell>
                                        <TableCell className="text-right">
                                            {socialAccounts && socialAccounts.includes(provider.id) ? (
                                                <Button variant="destructive">
                                                    <Link
                                                        href={route('auth.socialite.disconnect', { driver: provider.id })}
                                                        method="DELETE"
                                                        as="button"
                                                        tabIndex={6}
                                                    >
                                                        Disconnect
                                                    </Link>
                                                </Button>
                                            ) : (
                                                <Button>
                                                    <Link href={route('auth.socialite.redirect', provider.name)} tabIndex={6}>
                                                        Connect
                                                    </Link>
                                                </Button>
                                            )}
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </div>
                </div>
            </SettingsLayout>
        </AppLayout>
    );
};

export default SocialiteSettings;
