import HeadingSmall from '@/components/heading-small';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AdminLayout from '@/layouts/admin-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

interface User {
    id: number;
    name: string;
    // Add other user properties as needed
}

interface PageProps {
    users: {
        data: User[];
    };
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/admin/users',
    },
];

export default function UserIndex() {
    const { props } = usePage<PageProps>();
    const users = props.users.data;

    return (
        <AdminLayout breadcrumbs={breadcrumbs}>
            <Head title="Users Management" />

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <HeadingSmall title="Users Accounts Information" description="Create, read, update, and delete user accounts" />

                <div className="overflow-x-auto rounded-md border">
                    <Table>
                        <TableCaption>A list of all registered users.</TableCaption>
                        <TableHeader className="bg-gray-50">
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead className="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {users.length > 0 ? (
                                users.map((user) => (
                                    <TableRow key={user.id} className="hover:bg-gray-50">
                                        <TableCell className="font-medium capitalize">{user.name}</TableCell>
                                        <TableCell className="space-x-2 text-right">
                                            {/* <Button variant="outline" size="sm" asChild>
                                                <Link href={route('admin.users.edit', user.id)}>Edit</Link>
                                            </Button> */}
                                            <Button variant="destructive" size="sm" asChild>
                                                <Link href={route('admin.users.destroy', user.id)} method="delete" as="button" preserveScroll>
                                                    Remove
                                                </Link>
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))
                            ) : (
                                <TableRow>
                                    <TableCell colSpan={2} className="text-center">
                                        No users found
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>
            </div>
        </AdminLayout>
    );
}
