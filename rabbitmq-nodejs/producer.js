import {connect} from 'amqplib';

const connection = await connect('amqp://guest:guest@localhost:5672');
const channel = await connection.createChannel();

for (let i = 0; i < 10; i++) {
    channel.publish('notifications', 'sms', Buffer.from(`sms ${i}`), {
        headers: {
            'sample': 'value'
        }
    })
}

await channel.close();
await connection.close();