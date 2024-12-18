import React from 'react';

interface Column {
  header: string;
  accessor: string;
}

type Row = {
  [key: string]: string | number | boolean | null; // You can specify more precise types based on your needs
};

interface TableProps<T extends Row> {
  columns: Column[];
  data: T[]; // This will now be strongly typed based on the columns
}

const Table = <T extends Row>({ columns, data }: TableProps<T>) => {
  return (
    <div className="overflow-x-auto">
      <table className="min-w-full bg-white">
        <thead className="bg-gray-50">
          <tr>
            {columns.map((column) => (
              <th
                key={column.accessor}
                className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
              >
                {column.header}
              </th>
            ))}
          </tr>
        </thead>
        <tbody className="bg-white divide-y divide-gray-200">
          {data.map((row, rowIndex) => (
            <tr key={rowIndex}>
              {columns.map((column) => (
                <td key={column.accessor} className="px-6 py-4 whitespace-nowrap">
                  {row[column.accessor as keyof T]} {/* Type casting to T */}
                </td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Table;
